<?php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('CONTATO_DESTINO', 'periodicos.ufpb@gmail.com');
define('ANEXO_TAMANHO_MAXIMO', 8 * 1024 * 1024); // 8MB
define('ANEXO_EXTENSOES_PERMITIDAS', ['pdf', 'doc', 'docx', 'odt', 'jpg', 'jpeg', 'png', 'zip']);

$ajudaSmtpConfigFile = __DIR__ . '/smtp-config.php';
if (is_readable($ajudaSmtpConfigFile)) {
    require $ajudaSmtpConfigFile;
}
if (!defined('SMTP_USER')) {
    define('SMTP_USER', getenv('SMTP_USER') ?: '');
}
if (!defined('SMTP_PASS')) {
    define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
}

/**
 * Envia um e-mail autenticando diretamente no SMTP do Gmail (STARTTLS).
 * Retorna true/false; em caso de falha, preenche $erro com detalhes
 * (usado apenas em log interno, nunca exibido ao usuário final).
 *
 * $anexo, quando informado, é um array ['nome' => ..., 'tipo' => ...,
 * 'conteudo' => <bytes do arquivo>] e o e-mail é montado como
 * multipart/mixed para incluí-lo.
 */
function ajuda_smtp_enviar($destino, $assunto, $corpo, $nomeRemetente, $emailResposta, &$erro, $anexo = null)
{
    $erro = '';
    $timeout = 15;

    $socket = @stream_socket_client(
        'tcp://' . SMTP_HOST . ':' . SMTP_PORT,
        $errno,
        $errstr,
        $timeout
    );
    if (!$socket) {
        $erro = "Falha ao conectar ao SMTP: $errstr ($errno)";
        return false;
    }
    stream_set_timeout($socket, $timeout);

    $ler = function () use ($socket) {
        $data = '';
        while (($linha = fgets($socket, 515)) !== false) {
            $data .= $linha;
            if (isset($linha[3]) && $linha[3] === ' ') {
                break;
            }
        }
        return $data;
    };
    $enviarCmd = function ($cmd) use ($socket) {
        fwrite($socket, $cmd . "\r\n");
    };

    $ler(); // greeting
    $enviarCmd('EHLO ' . SMTP_HOST);
    $ler();

    $enviarCmd('STARTTLS');
    $resp = $ler();
    if (strpos($resp, '220') !== 0) {
        $erro = "STARTTLS recusado: $resp";
        fclose($socket);
        return false;
    }

    if (!@stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
        $erro = 'Falha ao negociar TLS com o servidor SMTP.';
        fclose($socket);
        return false;
    }

    $enviarCmd('EHLO ' . SMTP_HOST);
    $ler();

    $enviarCmd('AUTH LOGIN');
    $ler();
    $enviarCmd(base64_encode(SMTP_USER));
    $ler();
    $enviarCmd(base64_encode(SMTP_PASS));
    $resp = $ler();
    if (strpos($resp, '235') !== 0) {
        $erro = "Autenticação SMTP falhou (verifique a senha de app configurada): $resp";
        fclose($socket);
        return false;
    }

    $enviarCmd('MAIL FROM: <' . SMTP_USER . '>');
    $ler();
    $enviarCmd('RCPT TO: <' . $destino . '>');
    $resp = $ler();
    if (strpos($resp, '250') !== 0) {
        $erro = "Destinatário recusado: $resp";
        fclose($socket);
        return false;
    }

    $enviarCmd('DATA');
    $ler();

    $headers = 'From: ' . $nomeRemetente . ' <' . SMTP_USER . ">\r\n";
    $headers .= 'Reply-To: ' . $emailResposta . "\r\n";
    $headers .= 'To: <' . $destino . ">\r\n";
    $headers .= 'Subject: =?UTF-8?B?' . base64_encode($assunto) . "?=\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= 'Date: ' . date('r') . "\r\n";

    if ($anexo) {
        $boundary = 'AjudaUFPB-' . md5(uniqid('', true));
        $headers .= 'Content-Type: multipart/mixed; boundary="' . $boundary . "\"\r\n";

        $mensagem = "--{$boundary}\r\n";
        $mensagem .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $mensagem .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $mensagem .= $corpo . "\r\n\r\n";

        $nomeAnexo = str_replace(['"', "\r", "\n"], '', $anexo['nome']);
        $mensagem .= "--{$boundary}\r\n";
        $mensagem .= 'Content-Type: ' . $anexo['tipo'] . '; name="' . $nomeAnexo . "\"\r\n";
        $mensagem .= "Content-Transfer-Encoding: base64\r\n";
        $mensagem .= 'Content-Disposition: attachment; filename="' . $nomeAnexo . "\"\r\n\r\n";
        $mensagem .= chunk_split(base64_encode($anexo['conteudo']));
        $mensagem .= "--{$boundary}--";
    } else {
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $mensagem = $corpo;
    }

    $mensagemEscapada = preg_replace('/^\./m', '..', $mensagem);
    $enviarCmd($headers . "\r\n" . $mensagemEscapada . "\r\n.");
    $resp = $ler();
    if (strpos($resp, '250') !== 0) {
        $erro = "Servidor recusou o envio: $resp";
        fclose($socket);
        return false;
    }

    $enviarCmd('QUIT');
    fclose($socket);
    return true;
}

$formStatus = null; // 'success' | 'error' | null
$formErrors = [];
$old = ['nome' => '', 'email' => '', 'revista' => '', 'assunto' => '', 'mensagem' => ''];

// Quando o anexo (ou o POST inteiro) excede o limite do próprio servidor
// (post_max_size no php.ini), o PHP descarta $_POST/$_FILES silenciosamente
// antes mesmo deste script rodar. Detectamos esse caso para não deixar o
// formulário "sumir" sem explicação.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
    $formStatus = 'error';
    $formErrors[] = 'O arquivo enviado é muito grande para o limite configurado no servidor. Tente um arquivo menor ou envie sem anexo.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajuda_contato_submit'])) {
    $old['nome'] = trim((string)($_POST['nome'] ?? ''));
    $old['email'] = trim((string)($_POST['email'] ?? ''));
    $old['revista'] = trim((string)($_POST['revista'] ?? ''));
    $old['assunto'] = trim((string)($_POST['assunto'] ?? ''));
    $old['mensagem'] = trim((string)($_POST['mensagem'] ?? ''));
    $honeypot = trim((string)($_POST['site_url'] ?? ''));
    $carimbo = (int)($_POST['form_ts'] ?? 0);

    if ($honeypot !== '') {
        // Provável robô: finge sucesso e não envia nada.
        $formStatus = 'success';
        $old = ['nome' => '', 'email' => '', 'revista' => '', 'assunto' => '', 'mensagem' => ''];
    } else {
        if ($old['nome'] === '' || mb_strlen($old['nome']) < 2) {
            $formErrors[] = 'Informe seu nome.';
        }
        if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $formErrors[] = 'Informe um e-mail válido.';
        }
        if ($old['mensagem'] === '' || mb_strlen($old['mensagem']) < 10) {
            $formErrors[] = 'Escreva uma mensagem com pelo menos 10 caracteres.';
        }
        if ($carimbo > 0 && (time() - $carimbo) < 3) {
            $formErrors[] = 'O envio foi rápido demais. Tente novamente.';
        }

        $anexoValidado = null;
        if (!empty($_FILES['anexo']) && $_FILES['anexo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $arquivo = $_FILES['anexo'];
            if ($arquivo['error'] === UPLOAD_ERR_INI_SIZE || $arquivo['error'] === UPLOAD_ERR_FORM_SIZE) {
                $formErrors[] = 'O arquivo é muito grande para o limite configurado no servidor. Tente um arquivo menor.';
            } elseif ($arquivo['error'] !== UPLOAD_ERR_OK) {
                $formErrors[] = 'Não foi possível enviar o arquivo anexado. Tente novamente ou envie sem anexo.';
            } elseif ($arquivo['size'] > ANEXO_TAMANHO_MAXIMO) {
                $formErrors[] = 'O arquivo anexado deve ter no máximo ' . (ANEXO_TAMANHO_MAXIMO / 1024 / 1024) . 'MB.';
            } else {
                $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                if (!in_array($extensao, ANEXO_EXTENSOES_PERMITIDAS, true)) {
                    $formErrors[] = 'Formato de arquivo não permitido. Envie PDF, DOC, DOCX, ODT, JPG, PNG ou ZIP.';
                } else {
                    $conteudoArquivo = file_get_contents($arquivo['tmp_name']);
                    if ($conteudoArquivo === false) {
                        $formErrors[] = 'Não foi possível ler o arquivo anexado. Tente novamente.';
                    } else {
                        $anexoValidado = [
                            'nome' => basename($arquivo['name']),
                            'tipo' => $arquivo['type'] ?: 'application/octet-stream',
                            'conteudo' => $conteudoArquivo,
                        ];
                    }
                }
            }
        }

        if (empty($formErrors)) {
            $assuntoFinal = $old['assunto'] !== '' ? $old['assunto'] : 'Fale Conosco - Central de Ajuda';
            $corpo = "Nova mensagem recebida pelo formulário da Central de Ajuda\n\n";
            $corpo .= 'Nome: ' . $old['nome'] . "\n";
            $corpo .= 'E-mail: ' . $old['email'] . "\n";
            if ($old['revista'] !== '') {
                $corpo .= 'Revista: ' . $old['revista'] . "\n";
            }
            $corpo .= 'Assunto: ' . $assuntoFinal . "\n\n";
            $corpo .= "Mensagem:\n" . $old['mensagem'] . "\n";
            if ($anexoValidado) {
                $corpo .= "\nArquivo anexado: " . $anexoValidado['nome'] . "\n";
            }

            $erroSmtp = '';
            if (SMTP_USER === '' || SMTP_PASS === '') {
                $enviado = false;
                $erroSmtp = 'SMTP não configurado (crie smtp-config.php ou defina SMTP_USER/SMTP_PASS no servidor).';
            } else {
                $enviado = ajuda_smtp_enviar(
                    CONTATO_DESTINO,
                    '[Central de Ajuda] ' . $assuntoFinal . ' - ' . $old['nome'],
                    $corpo,
                    $old['nome'],
                    $old['email'],
                    $erroSmtp,
                    $anexoValidado
                );
            }

            if ($enviado) {
                $formStatus = 'success';
                $old = ['nome' => '', 'email' => '', 'revista' => '', 'assunto' => '', 'mensagem' => ''];
            } else {
                $formStatus = 'error';
                if (function_exists('error_log')) {
                    error_log('[Central de Ajuda] Falha ao enviar e-mail: ' . $erroSmtp);
                }
            }
        } else {
            $formStatus = 'error';
        }
    }
}
?>
<?php include 'header.html'; ?>

<style>
/* ── Hero ── */
#ajuda-hero {
    background: linear-gradient(135deg, #E8682A 0%, #c4521a 100%);
    padding: 70px 0 60px;
    text-align: center;
    color: #fff !important;
    position: relative;
    overflow: hidden;
}
#ajuda-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    pointer-events: none;
}
#ajuda-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -40px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}
#ajuda-hero h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
    color: #fff !important;
}
#ajuda-hero p {
    font-size: 1.05rem;
    opacity: 0.92;
    max-width: 560px;
    margin: 0 auto;
    color: #fff !important;
    line-height: 1.65;
}
#ajuda-hero .hero-content {
    position: relative;
    z-index: 2;
}
#ajuda-hero .hero-wave {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    line-height: 0;
}

/* ── Busca rápida no hero ── */
.hero-busca {
    position: relative;
    max-width: 480px;
    margin: 28px auto 0;
    z-index: 3;
}
.hero-busca input {
    width: 100%;
    border: none;
    border-radius: 40px;
    padding: 14px 22px 14px 46px;
    font-size: 0.98rem;
    box-shadow: 0 6px 20px rgba(0,0,0,0.18);
    outline: none;
}
.hero-busca input:focus {
    box-shadow: 0 6px 20px rgba(0,0,0,0.18), 0 0 0 3px rgba(255,255,255,0.5);
}
.hero-busca .busca-icone {
    position: absolute;
    left: 18px; top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 1rem;
    pointer-events: none;
}
.hero-busca .busca-resultados {
    left: 0; right: 0;
}

/* ── Tabs ── */
.ajuda-tabs {
    background: #fff;
    border-bottom: 2px solid #e8e8e8;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.ajuda-tabs .nav-tabs {
    border: none;
    justify-content: center;
    gap: 4px;
    padding: 8px 0 0;
    flex-wrap: wrap;
}
.ajuda-tabs .nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #666;
    font-weight: 500;
    font-size: 0.97rem;
    padding: 10px 28px 9px;
    border-radius: 0;
    transition: all 0.2s;
    cursor: pointer;
}
.ajuda-tabs .nav-tabs .nav-link:hover {
    color: #3a3a3a;
    border-bottom-color: #c0c8d8;
}
.ajuda-tabs .nav-tabs .nav-link.active {
    color: #E8682A;
    border-bottom-color: #E8682A;
    font-weight: 600;
    background: none;
}

/* ── Busca (barra fixa sob as abas) ── */
.ajuda-busca-bar {
    padding: 10px 0 14px;
    display: flex;
    justify-content: center;
}
.ajuda-busca-bar .busca-wrap {
    position: relative;
    width: 100%;
    max-width: 480px;
}
.ajuda-busca-bar input {
    width: 100%;
    border: 1.5px solid #e2e2e2;
    border-radius: 30px;
    padding: 9px 18px 9px 38px;
    font-size: 0.92rem;
    outline: none;
    transition: border-color 0.2s;
    background: #f8f9fa url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='16' height='16' fill='none' stroke='%23999' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='7'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E") no-repeat 13px center;
}
.ajuda-busca-bar input:focus {
    border-color: #E8682A;
    background-color: #fff;
}
.busca-resultados {
    position: absolute;
    top: calc(100% + 6px);
    left: 0; right: 0;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.16);
    overflow: hidden;
    max-height: 360px;
    overflow-y: auto;
    z-index: 200;
    text-align: left;
}
.busca-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    width: 100%;
    border: none;
    background: #fff;
    padding: 11px 16px;
    font-size: 0.88rem;
    color: #3a3a3a;
    text-align: left;
    border-bottom: 1px solid #f2f2f2;
    cursor: pointer;
}
.busca-item:last-child { border-bottom: none; }
.busca-item:hover { background: #fff5f0; color: #E8682A; }
.busca-pergunta { flex: 1; }
.busca-cat {
    flex-shrink: 0;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: #c4521a;
    background: #fdece2;
    padding: 2px 9px;
    border-radius: 20px;
}
.busca-vazio {
    padding: 16px;
    font-size: 0.88rem;
    color: #666;
    line-height: 1.6;
    text-align: center;
}
.busca-vazio a { color: #E8682A; font-weight: 600; }

@keyframes buscaFlash {
    0% { background: #fff3e8; }
    100% { background: transparent; }
}
.busca-destaque {
    animation: buscaFlash 2.2s ease;
    border-radius: 10px;
}

/* ── Section ── */
.ajuda-section {
    padding: 52px 0 60px;
}
.ajuda-section.gray {
    background: #f2f4f6;
}
.ajuda-section .section-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #3a3a3a;
    margin-bottom: 6px;
}
.ajuda-section .section-subtitle {
    color: #666;
    margin-bottom: 32px;
    font-size: 0.97rem;
}

/* ── Subgrupos de FAQ dentro de cada aba ── */
.faq-group {
    margin-bottom: 38px;
}
.faq-group:last-child { margin-bottom: 0; }
.faq-group-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.02rem;
    font-weight: 700;
    color: #3a3a3a;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 2px solid #f0f0f0;
}
.faq-group-title .fg-icon {
    font-size: 1.1rem;
}

/* ── Accordion custom ── */
.faq-card {
    border: none;
    border-radius: 10px !important;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    overflow: hidden;
}
.faq-card .card-header {
    background: #fff;
    border: none;
    padding: 0;
}
.faq-card .card-header button {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    padding: 16px 20px;
    font-size: 0.97rem;
    font-weight: 600;
    color: #3a3a3a;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.2s;
}
.faq-card .card-header button:hover {
    background: #f8f9fa;
}
.faq-card .card-header button[aria-expanded="true"] {
    color: #E8682A;
    border-bottom: 1px solid #f0f0f0;
}
.faq-card .card-header button .faq-icon {
    font-size: 1.2rem;
    font-weight: 300;
    color: #E8682A;
    flex-shrink: 0;
    margin-left: 12px;
    transition: transform 0.2s;
}
.faq-card .card-header button[aria-expanded="true"] .faq-icon {
    transform: rotate(45deg);
}
.faq-card .card-body {
    padding: 20px 24px;
    font-size: 0.95rem;
    color: #444;
    line-height: 1.7;
}
.faq-card .card-body ul,
.faq-card .card-body ol {
    padding-left: 1.4em;
    margin-bottom: 0;
}
.faq-card .card-body li {
    margin-bottom: 6px;
}
.faq-card .card-body a {
    color: #E8682A;
    font-weight: 500;
}
.faq-card .card-body strong {
    color: #3a3a3a;
}

/* ── Info cards ── */
.info-card {
    background: #fff;
    border-radius: 12px;
    padding: 28px 24px;
    box-shadow: 0 3px 14px rgba(0,0,0,0.07);
    height: 100%;
}
.info-card .ic-icon {
    font-size: 1.8rem;
    margin-bottom: 14px;
}
.info-card h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #3a3a3a;
    margin-bottom: 10px;
}
.info-card p, .info-card a {
    font-size: 0.93rem;
    color: #555;
    line-height: 1.6;
}
.info-card a {
    color: #E8682A;
}

/* ── Metadados checklist ── */
.meta-block {
    background: #fff;
    border-radius: 10px;
    padding: 22px 24px;
    margin-bottom: 14px;
    border-left: 4px solid #3a3a3a;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.meta-block h5 {
    font-size: 0.97rem;
    font-weight: 700;
    color: #3a3a3a;
    margin-bottom: 8px;
}
.meta-block p, .meta-block ul {
    font-size: 0.93rem;
    color: #555;
    margin-bottom: 0;
    line-height: 1.65;
}
.meta-block ul {
    padding-left: 1.4em;
}

/* ── Checklist ── */
.checklist-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    font-size: 0.93rem;
    color: #444;
}
.checklist-item:last-child { border-bottom: none; }
.checklist-item .check-num {
    flex-shrink: 0;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #E8682A;
    color: #fff;
    font-size: 0.78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1px;
}

/* ── Contact section ── */
#contato-ajuda {
    background: linear-gradient(135deg, #E8682A 0%, #c4521a 100%);
    color: #fff !important;
    padding: 60px 0 64px;
    position: relative;
    overflow: hidden;
}
#contato-ajuda::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    pointer-events: none;
}
#contato-ajuda::after {
    content: '';
    position: absolute;
    bottom: -70px; left: -40px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}
#contato-ajuda .contato-content {
    position: relative;
    z-index: 2;
    text-align: center;
}
#contato-ajuda h2 {
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 10px;
    color: #fff !important;
    letter-spacing: -0.02em;
}
#contato-ajuda > .container > .contato-content > p {
    opacity: 0.92;
    max-width: 560px;
    margin: 0 auto 30px;
    color: #fff !important;
    line-height: 1.65;
}
.contact-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.4);
    border-radius: 40px;
    padding: 10px 22px;
    color: #fff;
    font-size: 0.95rem;
    text-decoration: none;
    margin: 6px;
    transition: background 0.2s;
}
.contact-pill:hover {
    background: rgba(255,255,255,0.32);
    color: #fff;
    text-decoration: none;
}
.contact-pill strong { font-weight: 600; }

.contato-form-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px 30px;
    margin: 36px auto 0;
    max-width: 640px;
    text-align: left;
    box-shadow: 0 14px 40px rgba(0,0,0,0.22);
}
.contato-form-card h3 {
    color: #3a3a3a;
    font-size: 1.12rem;
    font-weight: 700;
    margin-bottom: 4px;
}
.contato-form-card .form-lead {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 20px;
}
.form-row {
    margin-bottom: 16px;
}
.form-row label {
    display: block;
    font-size: 0.86rem;
    font-weight: 600;
    color: #3a3a3a;
    margin-bottom: 6px;
}
.form-row input[type="text"],
.form-row input[type="email"],
.form-row select,
.form-row textarea {
    width: 100%;
    border: 1.5px solid #e2e2e2;
    border-radius: 8px;
    padding: 10px 13px;
    font-size: 0.92rem;
    color: #333;
    outline: none;
    transition: border-color 0.2s;
    font-family: inherit;
    background: #fff;
}
.form-row input:focus,
.form-row select:focus,
.form-row textarea:focus {
    border-color: #E8682A;
}
.form-row textarea { resize: vertical; min-height: 100px; }
.form-row input[type="file"] {
    width: 100%;
    border: 1.5px dashed #e2e2e2;
    border-radius: 8px;
    padding: 10px 13px;
    font-size: 0.86rem;
    color: #555;
    background: #fafafa;
}
.form-row input[type="file"]:focus { border-color: #E8682A; }
.form-hint {
    font-size: 0.78rem;
    color: #888;
    margin: 6px 0 0;
    line-height: 1.5;
}
.form-hint-error { color: #c0392b; font-weight: 600; }
.form-cols {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
@media (max-width: 575px) {
    .form-cols { grid-template-columns: 1fr; }
}
.hp-field {
    position: absolute;
    left: -9999px;
    top: -9999px;
    width: 1px; height: 1px;
    overflow: hidden;
}
.btn-enviar {
    width: 100%;
    background: #E8682A;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 13px 20px;
    font-size: 0.97rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-enviar:hover { background: #c4521a; }
.form-alert {
    border-radius: 8px;
    padding: 13px 16px;
    font-size: 0.88rem;
    margin-bottom: 18px;
    line-height: 1.6;
}
.form-alert-success {
    background: #d4edda;
    color: #155724;
}
.form-alert-error {
    background: #f8d7da;
    color: #721c24;
}
.form-alert-error ul {
    margin: 6px 0 0;
    padding-left: 1.2em;
}
.contato-alt {
    margin-top: 26px;
}

/* ── Tabela de similaridade ── */
.table-responsive-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin-top: 12px;
    border-radius: 8px;
}
.similaridade-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    min-width: 420px;
}
.similaridade-table th {
    background: #3a3a3a;
    color: #fff;
    padding: 10px 14px;
    text-align: left;
    font-weight: 600;
}
.similaridade-table td {
    padding: 10px 14px;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}
.similaridade-table tr:last-child td { border-bottom: none; }
.badge-nivel {
    display: inline-block;
    border-radius: 20px;
    padding: 3px 12px;
    font-size: 0.8rem;
    font-weight: 700;
}
.badge-ok    { background: #d4edda; color: #155724; }
.badge-warn  { background: #fff3cd; color: #856404; }
.badge-grave { background: #ffd5b0; color: #7d3200; }
.badge-crit  { background: #f8d7da; color: #721c24; }

/* ── Responsivo — aba integridade ── */
@media (max-width: 767px) {
    .similaridade-table { font-size: 0.82rem; }
    .similaridade-table th,
    .similaridade-table td { padding: 8px 10px; }
}

/* ── Aviso integridade ── */
.aviso-integridade {
    background: #fff8f5;
    border-left: 4px solid #E8682A;
    border-radius: 0 8px 8px 0;
    padding: 12px 16px;
    font-size: 0.9rem;
    color: #5a3010;
    margin-top: 14px;
    line-height: 1.6;
}

/* ── Etiqueta de público no card ── */
.card-audience-tag {
    display: inline-block;
    background: #fdece2;
    color: #c4521a;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 10px;
}

/* ── Responsive ── */
@media (max-width: 767px) {
    #ajuda-hero h1 { font-size: 1.4rem; }
    .ajuda-tabs .nav-tabs .nav-link { padding: 10px 14px; font-size: 0.9rem; }
}
</style>

<!-- Hero -->
<section id="ajuda-hero">
    <div class="container hero-content">
        <h1>Central de Ajuda</h1>
        <p>Encontre respostas, guias e tutoriais para autores, avaliadores e editores do Portal de Periódicos da UFPB.</p>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:48px; display:block;">
            <path d="M0,32 C360,0 1080,60 1440,20 L1440,48 L0,48 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<!-- Tabs + Busca -->
<div class="ajuda-tabs">
    <div class="container">
        <ul class="nav nav-tabs" id="ajudaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="autores-tab" data-toggle="tab" href="#autores" role="tab"
                   aria-controls="autores" aria-selected="true">
                    Para Autores e Leitores
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="editores-tab" data-toggle="tab" href="#editores" role="tab"
                   aria-controls="editores" aria-selected="false">
                    Para Editores
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="integridade-tab" data-toggle="tab" href="#integridade" role="tab"
                   aria-controls="integridade" aria-selected="false">
                    Integridade Acadêmica
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="recursos-tab" data-toggle="tab" href="#recursos" role="tab"
                   aria-controls="recursos" aria-selected="false">
                    Manuais, Guias e Tutoriais
                </a>
            </li>
        </ul>
        <div class="ajuda-busca-bar">
            <div class="busca-wrap">
                <input type="text" id="buscaAjuda" placeholder="Buscar em todas as perguntas (ex: DOI, senha, ORCID, submissão...)" autocomplete="off" aria-label="Buscar nas perguntas frequentes">
                <div id="buscaResultados" class="busca-resultados" hidden></div>
            </div>
        </div>
    </div>
</div>

<!-- Tab Content -->
<div class="tab-content" id="ajudaTabContent">

    <!-- ===== ABA AUTORES ===== -->
    <div class="tab-pane fade show active" id="autores" role="tabpanel" aria-labelledby="autores-tab">

        <section class="ajuda-section">
            <div class="container">
                <p class="section-title">Perguntas Frequentes</p>
                <p class="section-subtitle">Respostas às dúvidas mais comuns de autores, leitores e avaliadores. Use a busca acima para encontrar rapidamente o que precisa.</p>

                <!-- Grupo: Cadastro e Acesso -->
                <div class="faq-group" data-cat="Cadastro e Acesso">
                    <p class="faq-group-title"><span class="fg-icon">🔑</span> Cadastro e Acesso</p>
                    <div id="accordionCA">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cCA0">
                            <div class="card-header" id="hCA0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cCA0"
                                        aria-expanded="false" aria-controls="cCA0">
                                    Como me cadastrar no Portal?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cCA0" class="collapse" aria-labelledby="hCA0" data-parent="#accordionCA">
                                <div class="card-body">
                                    <p>O cadastro é realizado diretamente no site da revista em que você deseja submeter ou acompanhar um trabalho. Clique em <strong>"Acesso"</strong> no menu superior da revista e, em seguida, em <strong>"Cadastro"</strong> ou <strong>"Registrar"</strong> (conforme a versão do OJS), ou acesse diretamente o link:
                                    <a href="https://periodicos.ufpb.br/index.php/index/user/register" target="_blank">
                                        periodicos.ufpb.br → Registrar
                                    </a>.</p>
                                    <p>Preencha as informações solicitadas — nome, e-mail, instituição e país — e conclua o cadastro. Após a confirmação por e-mail, você poderá submeter artigos, acompanhar avaliações e acessar conteúdo restrito.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cCA1">
                            <div class="card-header" id="hCA1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cCA1"
                                        aria-expanded="false" aria-controls="cCA1">
                                    Não consigo realizar meu cadastro. O que devo fazer?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cCA1" class="collapse" aria-labelledby="hCA1" data-parent="#accordionCA">
                                <div class="card-body">
                                    <p>Verifique se o login não contém letras maiúsculas, espaços ou caracteres não aceitos pelo sistema. Se o problema persistir, envie ao Portal uma captura de tela da mensagem de erro, o login, o e-mail utilizado e o nome da revista pelo <a href="#form-contato">formulário de contato</a>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cCA2">
                            <div class="card-header" id="hCA2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cCA2"
                                        aria-expanded="false" aria-controls="cCA2">
                                    Como recuperar minha senha?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cCA2" class="collapse" aria-labelledby="hCA2" data-parent="#accordionCA">
                                <div class="card-body">
                                    <p>Na página da revista, acesse <strong>"Acesso"</strong> e selecione <strong>"Esqueceu a senha?"</strong>. Informe o e-mail cadastrado e siga as instruções recebidas para criar uma nova senha.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cCA3">
                            <div class="card-header" id="hCA3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cCA3"
                                        aria-expanded="false" aria-controls="cCA3">
                                    Não recebi o e-mail para recuperar minha senha. O que devo fazer?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cCA3" class="collapse" aria-labelledby="hCA3" data-parent="#accordionCA">
                                <div class="card-body">
                                    <p>Verifique as caixas de spam, lixo eletrônico e promoções. Confirme se o endereço informado é o mesmo utilizado no cadastro da revista. Se ainda assim não receber a mensagem, entre em contato conosco informando o e-mail cadastrado e o nome da revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cCA4">
                            <div class="card-header" id="hCA4">
                                <button class="collapsed" data-toggle="collapse" data-target="#cCA4"
                                        aria-expanded="false" aria-controls="cCA4">
                                    Como alterar meus dados cadastrais?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cCA4" class="collapse" aria-labelledby="hCA4" data-parent="#accordionCA">
                                <div class="card-body">
                                    <p>Acesse sua conta no OJS, selecione <strong>"Perfil"</strong> e atualize as informações disponíveis, como nome, e-mail, afiliação institucional e ORCID. Ao finalizar, clique em <strong>"Salvar"</strong>. Algumas alterações podem depender das permissões do usuário.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: Submissão -->
                <div class="faq-group" data-cat="Submissão">
                    <p class="faq-group-title"><span class="fg-icon">📤</span> Submissão de Artigos</p>
                    <div id="accordionSU">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cSU0">
                            <div class="card-header" id="hSU0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cSU0"
                                        aria-expanded="false" aria-controls="cSU0">
                                    Como submeter um artigo?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cSU0" class="collapse" aria-labelledby="hSU0" data-parent="#accordionSU">
                                <div class="card-body">
                                    <p>A submissão é feita diretamente no site de cada revista. Acesse <a href="https://periodicos.ufpb.br/capa/index.php" target="_blank">o Portal</a>, pesquise a revista desejada, faça login e clique em <strong>"Nova Submissão"</strong>. O processo envolve etapas como:</p>
                                    <ul>
                                        <li>Início — escolha da seção e confirmação das diretrizes</li>
                                        <li>Metadados — título, autores, resumo, palavras-chave</li>
                                        <li>Upload do arquivo — manuscrito principal e anexos</li>
                                        <li>Confirmação</li>
                                    </ul>
                                    <p>Consulte as Diretrizes para Autores específicas de cada revista antes de submeter.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cSU1">
                            <div class="card-header" id="hSU1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cSU1"
                                        aria-expanded="false" aria-controls="cSU1">
                                    Como saber se uma revista está recebendo submissões?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cSU1" class="collapse" aria-labelledby="hSU1" data-parent="#accordionSU">
                                <div class="card-body">
                                    <p>Consulte a página da revista no Portal e verifique as informações destinadas aos autores, as Diretrizes para Autores e, quando houver, chamadas para submissão. Em caso de dúvida, entre em contato diretamente com a equipe editorial da revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cSU2">
                            <div class="card-header" id="hSU2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cSU2"
                                        aria-expanded="false" aria-controls="cSU2">
                                    Quais são os requisitos para submeter um artigo?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cSU2" class="collapse" aria-labelledby="hSU2" data-parent="#accordionSU">
                                <div class="card-body">
                                    <p>Os requisitos são definidos por cada revista e podem variar. Consulte as Diretrizes para Autores para verificar os tipos de trabalhos aceitos, normas de formatação, documentos necessários, políticas editoriais e demais exigências.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cSU3">
                            <div class="card-header" id="hSU3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cSU3"
                                        aria-expanded="false" aria-controls="cSU3">
                                    Posso substituir um arquivo depois de enviar minha submissão?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cSU3" class="collapse" aria-labelledby="hSU3" data-parent="#accordionSU">
                                <div class="card-body">
                                    <p>A possibilidade de substituição depende da etapa em que a submissão se encontra. Após o início da avaliação editorial, o envio de uma nova versão poderá depender de solicitação ou autorização da equipe editorial da revista.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: Fluxo Editorial -->
                <div class="faq-group" data-cat="Fluxo Editorial">
                    <p class="faq-group-title"><span class="fg-icon">🔄</span> Acompanhamento e Fluxo Editorial</p>
                    <div id="accordionFE">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFE0">
                            <div class="card-header" id="hFE0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFE0"
                                        aria-expanded="false" aria-controls="cFE0">
                                    Como acompanhar o andamento da minha submissão?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFE0" class="collapse" aria-labelledby="hFE0" data-parent="#accordionFE">
                                <div class="card-body">
                                    <p>O acompanhamento é feito de duas formas:</p>
                                    <ul>
                                        <li><strong>Por e-mail:</strong> o sistema envia notificações automáticas para o endereço cadastrado a cada mudança de status.</li>
                                        <li><strong>Pelo painel do OJS:</strong> acesse sua conta, vá em <em>Submissões</em> e verifique o andamento no fluxo editorial.</li>
                                    </ul>
                                    <p>Em caso de demora, entre em contato diretamente com a editoria da revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFE1">
                            <div class="card-header" id="hFE1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFE1"
                                        aria-expanded="false" aria-controls="cFE1">
                                    Como saber se meu artigo foi encaminhado para avaliação?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFE1" class="collapse" aria-labelledby="hFE1" data-parent="#accordionFE">
                                <div class="card-body">
                                    <p>Consulte o status da submissão na área "Submissões" do OJS. As etapas do fluxo e as notificações enviadas pelo sistema podem indicar o andamento da avaliação. Se a informação não estiver clara, entre em contato com a equipe editorial.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFE2">
                            <div class="card-header" id="hFE2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFE2"
                                        aria-expanded="false" aria-controls="cFE2">
                                    Quanto tempo demora a avaliação de um artigo?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFE2" class="collapse" aria-labelledby="hFE2" data-parent="#accordionFE">
                                <div class="card-body">
                                    <p>O prazo varia de acordo com a revista, o tipo de publicação e o fluxo editorial adotado. O Portal não define nem controla os prazos de avaliação. Para informações sobre prazos, consulte a equipe editorial da revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFE3">
                            <div class="card-header" id="hFE3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFE3"
                                        aria-expanded="false" aria-controls="cFE3">
                                    Por que minha submissão está demorando?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFE3" class="collapse" aria-labelledby="hFE3" data-parent="#accordionFE">
                                <div class="card-body">
                                    <p>O tempo de processamento pode variar conforme as diferentes etapas do fluxo editorial, a disponibilidade de avaliadores e os procedimentos adotados pela revista. O Portal não interfere nas decisões ou nos prazos editoriais. Para informações específicas, entre em contato com a equipe editorial.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFE4">
                            <div class="card-header" id="hFE4">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFE4"
                                        aria-expanded="false" aria-controls="cFE4">
                                    Como saber se meu artigo foi aceito ou rejeitado?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFE4" class="collapse" aria-labelledby="hFE4" data-parent="#accordionFE">
                                <div class="card-body">
                                    <p>A decisão editorial é comunicada pelo OJS e/ou pelo e-mail cadastrado. Para informações sobre a decisão ou sobre o processo editorial, entre em contato diretamente com a equipe editorial da revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFE5">
                            <div class="card-header" id="hFE5">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFE5"
                                        aria-expanded="false" aria-controls="cFE5">
                                    Por que minha submissão foi rejeitada sem passar por avaliação?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFE5" class="collapse" aria-labelledby="hFE5" data-parent="#accordionFE">
                                <div class="card-body">
                                    <p>Uma submissão pode ser rejeitada antes da avaliação por diferentes motivos previstos nas políticas da revista. Em situações como encerramento das atividades editoriais ou suspensão do recebimento de submissões, pode ocorrer rejeição administrativa para que o autor possa submeter o trabalho a outro periódico. Nesses casos, a decisão não está relacionada ao mérito científico do trabalho.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: Avaliação por Pares -->
                <div class="faq-group" data-cat="Avaliação por Pares">
                    <p class="faq-group-title"><span class="fg-icon">🧑‍⚖️</span> Avaliação por Pares</p>
                    <div id="accordionAP">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAP0">
                            <div class="card-header" id="hAP0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAP0"
                                        aria-expanded="false" aria-controls="cAP0">
                                    Como funciona a avaliação por pares?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAP0" class="collapse" aria-labelledby="hAP0" data-parent="#accordionAP">
                                <div class="card-body">
                                    <p>A avaliação por pares é uma etapa do processo editorial na qual o manuscrito é analisado por especialistas da área, selecionados pela equipe editorial. Os procedimentos, critérios e modalidades de avaliação podem variar entre as revistas. Consulte as políticas editoriais e as Diretrizes para Autores do periódico.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAP1">
                            <div class="card-header" id="hAP1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAP1"
                                        aria-expanded="false" aria-controls="cAP1">
                                    Como posso me tornar avaliador(a) de uma revista?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAP1" class="collapse" aria-labelledby="hAP1" data-parent="#accordionAP">
                                <div class="card-body">
                                    <p>A seleção de avaliadores é responsabilidade da equipe editorial de cada revista, mas em algumas revistas é possível manifestar esse interesse diretamente pela plataforma: o OJS permite que o(a) próprio(a) usuário(a) solicite o papel de avaliador(a) no seu perfil, quando a revista tiver essa opção habilitada.</p>
                                    <ul>
                                        <li><strong>Pela plataforma:</strong> acesse sua conta no OJS da revista, vá em <em>"Editar Perfil"</em> e procure a seção de papéis/funções — se a revista tiver ativado o autocadastro de avaliadores, haverá uma opção para solicitar o papel de <strong>Avaliador(a)</strong> ali mesmo.</li>
                                        <li><strong>Quando a revista não oferecer essa opção no perfil:</strong> entre em contato diretamente com a equipe editorial ou manifeste seu interesse ao Portal pelo <a href="#form-contato">formulário de contato</a>, que poderá encaminhá-lo à editoria responsável, quando pertinente.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAP2">
                            <div class="card-header" id="hAP2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAP2"
                                        aria-expanded="false" aria-controls="cAP2">
                                    Fui convidado(a) para avaliar um artigo. Como devo proceder?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAP2" class="collapse" aria-labelledby="hAP2" data-parent="#accordionAP">
                                <div class="card-body">
                                    <p>Acesse sua conta no OJS e consulte o convite ou a área destinada às avaliações. A partir do convite, será possível verificar as informações da avaliação, aceitar ou recusar o convite e, caso aceite, realizar o parecer dentro do prazo estabelecido pela revista. Em caso de dúvida, entre em contato com a equipe editorial.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: Metadados, ORCID e Autoria -->
                <div class="faq-group" data-cat="Metadados e ORCID">
                    <p class="faq-group-title"><span class="fg-icon">🏷️</span> Metadados, ORCID e Autoria</p>
                    <div id="accordionMD">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cMD0">
                            <div class="card-header" id="hMD0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cMD0"
                                        aria-expanded="false" aria-controls="cMD0">
                                    Como preencher corretamente os metadados do artigo?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cMD0" class="collapse" aria-labelledby="hMD0" data-parent="#accordionMD">
                                <div class="card-body">
                                    <ul>
                                        <li><strong>Título:</strong> apenas a primeira palavra em maiúscula (exceto nomes próprios). No OJS, título e subtítulo são preenchidos em campos separados. Não use ponto final.</li>
                                        <li><strong>Autores:</strong> insira nome e sobrenome em campos separados. Não inclua títulos acadêmicos (Dr., Prof. etc.).</li>
                                        <li><strong>ORCID:</strong> no formato completo <code>https://orcid.org/0000-0000-0000-0000</code>.</li>
                                        <li><strong>Afiliação:</strong> informe departamento, instituição, cidade e país por extenso — sem siglas.</li>
                                        <li><strong>Resumo:</strong> 150 a 250 palavras, sem citações. Artigos em português exigem <em>abstract</em> em inglês.</li>
                                        <li><strong>Palavras-chave:</strong> 3 a 6 termos de vocabulário controlado.</li>
                                        <li><strong>Não use CAPS LOCK</strong> em nenhum campo.</li>
                                    </ul>
                                    <p style="margin-top:16px;">📄 O manual completo está disponível na aba <a href="#recursos" data-toggle="tab"><strong>Manuais, Guias e Tutoriais</strong></a>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cMD1">
                            <div class="card-header" id="hMD1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cMD1"
                                        aria-expanded="false" aria-controls="cMD1">
                                    Como adicionar ou corrigir meu ORCID?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cMD1" class="collapse" aria-labelledby="hMD1" data-parent="#accordionMD">
                                <div class="card-body">
                                    <p>O ORCID pode ser informado no perfil do usuário ou nos campos de autoria, conforme a etapa do processo. Utilize o identificador completo, no formato <code>https://orcid.org/0000-0000-0000-0000</code>. Caso o artigo já tenha sido publicado e seja necessária uma correção, entre em contato com a equipe editorial da revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cMD2">
                            <div class="card-header" id="hMD2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cMD2"
                                        aria-expanded="false" aria-controls="cMD2">
                                    Como corrigir o nome ou os dados de um autor?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cMD2" class="collapse" aria-labelledby="hMD2" data-parent="#accordionMD">
                                <div class="card-body">
                                    <div class="aviso-integridade">
                                        ⚠️ É importante manter nome, afiliação e currículo sempre atualizados <strong>antes da submissão</strong>. As informações exibidas na publicação são baseadas exatamente no que foi fornecido pelo(a) autor(a) no momento do cadastro — por isso os metadados precisam estar preenchidos corretamente desde o início, evitando a necessidade de correções depois.
                                    </div>
                                    <p style="margin-top:14px;">Antes da publicação, solicite a correção à equipe editorial da revista, que avaliará o pedido conforme suas políticas e a etapa editorial. Após a publicação, alterações de autoria ou metadados também devem ser encaminhadas à equipe editorial, que poderá solicitar apoio técnico ao Portal quando necessário.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: Publicação e DOI -->
                <div class="faq-group" data-cat="Publicação e DOI">
                    <p class="faq-group-title"><span class="fg-icon">🆔</span> Publicação e DOI</p>
                    <div id="accordionPD">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cPD0">
                            <div class="card-header" id="hPD0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cPD0"
                                        aria-expanded="false" aria-controls="cPD0">
                                    Meu artigo foi aceito. Quando ele será publicado?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cPD0" class="collapse" aria-labelledby="hPD0" data-parent="#accordionPD">
                                <div class="card-body">
                                    <p>Após a aprovação, o artigo segue as etapas editoriais de revisão, edição, preparação e publicação, conforme o fluxo adotado pela revista. O prazo de publicação é definido pela equipe editorial. Para informações sobre a previsão de publicação, entre em contato diretamente com a revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cPD1">
                            <div class="card-header" id="hPD1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cPD1"
                                        aria-expanded="false" aria-controls="cPD1">
                                    Como solicitar uma correção depois que o artigo foi publicado?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cPD1" class="collapse" aria-labelledby="hPD1" data-parent="#accordionPD">
                                <div class="card-body">
                                    <p>Solicitações de correção após a publicação devem ser encaminhadas à equipe editorial da revista, informando o artigo e a alteração necessária. A editoria avaliará a solicitação conforme suas políticas e, quando necessário, solicitará apoio técnico ao Portal.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cPD2">
                            <div class="card-header" id="hPD2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cPD2"
                                        aria-expanded="false" aria-controls="cPD2">
                                    O que é DOI?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cPD2" class="collapse" aria-labelledby="hPD2" data-parent="#accordionPD">
                                <div class="card-body">
                                    <p>DOI (Digital Object Identifier) é um identificador persistente utilizado para identificar e localizar uma publicação digital. Ele facilita o acesso, a identificação e a correta citação do documento, mesmo que seu endereço eletrônico seja alterado.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cPD3">
                            <div class="card-header" id="hPD3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cPD3"
                                        aria-expanded="false" aria-controls="cPD3">
                                    Quando meu artigo receberá um DOI?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cPD3" class="collapse" aria-labelledby="hPD3" data-parent="#accordionPD">
                                <div class="card-body">
                                    <p>O DOI é atribuído aos artigos publicados pelas revistas que participam do fluxo institucional de registro de DOI do Portal. A atribuição ocorre após a publicação, conforme os procedimentos adotados e a disponibilidade da revista para registro.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cPD4">
                            <div class="card-header" id="hPD4">
                                <button class="collapsed" data-toggle="collapse" data-target="#cPD4"
                                        aria-expanded="false" aria-controls="cPD4">
                                    Meu artigo foi publicado, mas ainda não possui DOI. O que devo fazer?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cPD4" class="collapse" aria-labelledby="hPD4" data-parent="#accordionPD">
                                <div class="card-body">
                                    <p>Verifique inicialmente se o artigo já foi incluído no fluxo de atribuição de DOI da revista. Caso o DOI ainda não esteja disponível, entre em contato com a equipe editorial para verificar a situação. Quando necessário, a editoria poderá solicitar apoio ao Portal.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cPD5">
                            <div class="card-header" id="hPD5">
                                <button class="collapsed" data-toggle="collapse" data-target="#cPD5"
                                        aria-expanded="false" aria-controls="cPD5">
                                    Como localizar o DOI de um artigo?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cPD5" class="collapse" aria-labelledby="hPD5" data-parent="#accordionPD">
                                <div class="card-body">
                                    <p>O DOI pode ser encontrado na página do artigo publicado, geralmente junto às informações bibliográficas e aos dados de identificação da publicação. Também pode estar disponível no próprio documento publicado pela revista.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: Acesso Aberto e Licenciamento -->
                <div class="faq-group" data-cat="Acesso Aberto e Licenciamento">
                    <p class="faq-group-title"><span class="fg-icon">🔓</span> Acesso Aberto e Licenciamento</p>
                    <div id="accordionAL">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAL0">
                            <div class="card-header" id="hAL0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAL0"
                                        aria-expanded="false" aria-controls="cAL0">
                                    O que é acesso aberto (Open Access)?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAL0" class="collapse" aria-labelledby="hAL0" data-parent="#accordionAL">
                                <div class="card-body">
                                    <p>Acesso aberto é o modelo de publicação científica em que o conteúdo fica disponível <strong>gratuita e integralmente</strong> para qualquer leitor, sem barreiras de assinatura, pagamento ou cadastro pago. Todas as revistas do Portal de Periódicos da UFPB seguem esse modelo, o que amplia o alcance e a visibilidade da produção científica publicada.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAL1">
                            <div class="card-header" id="hAL1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAL1"
                                        aria-expanded="false" aria-controls="cAL1">
                                    Qual é o tipo de acesso aberto adotado pelo Portal de Periódicos da UFPB?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAL1" class="collapse" aria-labelledby="hAL1" data-parent="#accordionAL">
                                <div class="card-body">
                                    <p>As revistas do Portal de Periódicos da UFPB adotam o modelo de acesso aberto <strong>diamante (Diamond OA)</strong>: a publicação é <strong>gratuita tanto para autores quanto para leitores</strong> — não há cobrança de taxa de processamento de artigo (APC) nem de assinatura para acesso ao conteúdo.</p>
                                    <p style="margin-top:14px;">Esse modelo costuma ser mantido por sociedades científicas, universidades ou instituições sem fins lucrativos, como é o caso do Portal, vinculado à UFPB (veja a pergunta sobre taxa de publicação, abaixo).</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAL2">
                            <div class="card-header" id="hAL2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAL2"
                                        aria-expanded="false" aria-controls="cAL2">
                                    O Portal de Periódicos da UFPB cobra taxa de publicação (APC) dos autores?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAL2" class="collapse" aria-labelledby="hAL2" data-parent="#accordionAL">
                                <div class="card-body">
                                    <p><strong>Não.</strong> As revistas do Portal de Periódicos da UFPB não cobram taxa de submissão nem taxa de publicação (APC — Article Processing Charge) dos autores. O acesso e a publicação são gratuitos, tanto para quem lê quanto para quem publica.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAL3">
                            <div class="card-header" id="hAL3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAL3"
                                        aria-expanded="false" aria-controls="cAL3">
                                    O que são as licenças Creative Commons e qual a revista utiliza?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAL3" class="collapse" aria-labelledby="hAL3" data-parent="#accordionAL">
                                <div class="card-body">
                                    <p>As licenças <strong>Creative Commons (CC)</strong> são um conjunto de licenças padronizadas que definem, de forma clara, como um trabalho pode ser reutilizado, distribuído ou adaptado por terceiros, sempre com a devida atribuição de autoria. A licença mais adotada por periódicos de acesso aberto é a <strong>CC BY</strong>, que permite o reuso do conteúdo desde que os créditos sejam dados aos(às) autores(as) originais.</p>
                                    <p>A licença exata pode variar de uma revista para outra dentro do Portal — ela costuma estar indicada na página "Sobre" ou nas "Diretrizes para Autores" de cada revista, dentro do próprio OJS.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cAL4">
                            <div class="card-header" id="hAL4">
                                <button class="collapsed" data-toggle="collapse" data-target="#cAL4"
                                        aria-expanded="false" aria-controls="cAL4">
                                    Ao publicar em acesso aberto, o autor perde os direitos autorais do trabalho?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cAL4" class="collapse" aria-labelledby="hAL4" data-parent="#accordionAL">
                                <div class="card-body">
                                    <p><strong>Não, de forma geral não.</strong> Publicar em acesso aberto não significa abrir mão da autoria: o(a) autor(a) continua sendo reconhecido(a) como criador(a) do trabalho. O que costuma ocorrer é a concessão de uma licença (como a CC BY) que autoriza a revista e o público a reproduzir e distribuir o conteúdo, mantendo sempre o crédito ao(à) autor(a) original.</p>
                                    <p style="margin-top:14px;">As condições exatas de cessão de direitos podem variar entre as revistas do Portal — vale a pena conferir a política editorial específica de cada uma antes da submissão.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: OJS -->
                <div class="faq-group" data-cat="OJS — Acesso e Suporte">
                    <p class="faq-group-title"><span class="fg-icon">💻</span> OJS — Acesso e Suporte Técnico</p>
                    <div id="accordionOJ">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cOJ0">
                            <div class="card-header" id="hOJ0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cOJ0"
                                        aria-expanded="false" aria-controls="cOJ0">
                                    O que é o OJS e como acessar o Guia do OJS 3.3?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cOJ0" class="collapse" aria-labelledby="hOJ0" data-parent="#accordionOJ">
                                <div class="card-body">
                                    <p>O <strong>OJS (Open Journal Systems)</strong> é o sistema utilizado pelo Portal de Periódicos da UFPB para gerenciamento e publicação das revistas científicas. Por meio dele são realizados procedimentos como cadastro de usuários, submissão, avaliação, edição e publicação de artigos.</p>
                                    <p>O <strong>Guia de Aprendizado do OJS 3.3</strong> é o manual oficial do Public Knowledge Project (PKP), traduzido para o português, e cobre todas as etapas do fluxo editorial.</p>
                                    <p>📘 O guia e o manual complementar da IBICT estão disponíveis na aba <a href="#recursos" data-toggle="tab"><strong>Manuais, Guias e Tutoriais</strong></a>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cOJ1">
                            <div class="card-header" id="hOJ1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cOJ1"
                                        aria-expanded="false" aria-controls="cOJ1">
                                    Como acessar o OJS de uma revista?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cOJ1" class="collapse" aria-labelledby="hOJ1" data-parent="#accordionOJ">
                                <div class="card-body">
                                    <p>Para acessar o OJS, entre na página da revista pelo Portal de Periódicos da UFPB e selecione "Acesso". Utilize seu usuário e senha cadastrados na revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cOJ2">
                            <div class="card-header" id="hOJ2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cOJ2"
                                        aria-expanded="false" aria-controls="cOJ2">
                                    O OJS apresentou um erro. O que devo fazer?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cOJ2" class="collapse" aria-labelledby="hOJ2" data-parent="#accordionOJ">
                                <div class="card-body">
                                    <p>Registre a mensagem apresentada pelo sistema e, se possível, faça uma captura de tela. Informe o nome da revista, a etapa em que o erro ocorreu e as ações realizadas antes do problema pelo <a href="#form-contato">formulário de contato</a>. Essas informações ajudam na identificação e no encaminhamento da ocorrência.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cOJ3">
                            <div class="card-header" id="hOJ3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cOJ3"
                                        aria-expanded="false" aria-controls="cOJ3">
                                    Não consigo acessar minha conta no OJS. O que devo fazer?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cOJ3" class="collapse" aria-labelledby="hOJ3" data-parent="#accordionOJ">
                                <div class="card-body">
                                    <p>Verifique se o usuário e a senha estão corretos e tente utilizar a opção "Esqueceu a senha?" para recuperar o acesso. Se o problema persistir, informe o nome da revista, o usuário ou e-mail cadastrado e, se houver, envie uma captura de tela do erro ao Portal ou à equipe editorial, conforme a situação.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cOJ4">
                            <div class="card-header" id="hOJ4">
                                <button class="collapsed" data-toggle="collapse" data-target="#cOJ4"
                                        aria-expanded="false" aria-controls="cOJ4">
                                    Por que não consigo realizar uma determinada ação no OJS?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cOJ4" class="collapse" aria-labelledby="hOJ4" data-parent="#accordionOJ">
                                <div class="card-body">
                                    <p>As funcionalidades disponíveis dependem do perfil e das permissões atribuídas ao usuário, além da etapa do fluxo editorial. Caso uma função necessária não esteja disponível, entre em contato com a equipe editorial para verificar as permissões e, quando necessário, solicitar suporte ao Portal.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cOJ5">
                            <div class="card-header" id="hOJ5">
                                <button class="collapsed" data-toggle="collapse" data-target="#cOJ5"
                                        aria-expanded="false" aria-controls="cOJ5">
                                    O que devo informar ao solicitar suporte para um problema no OJS?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cOJ5" class="collapse" aria-labelledby="hOJ5" data-parent="#accordionOJ">
                                <div class="card-body">
                                    <p>Informe o nome da revista, seu usuário ou e-mail cadastrado, a etapa em que o problema ocorreu, a ação realizada, a mensagem de erro apresentada e, quando possível, uma captura de tela. Essas informações facilitam a identificação do problema. Envie tudo pelo <a href="#form-contato">formulário de contato</a> abaixo.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cOJ6">
                            <div class="card-header" id="hOJ6">
                                <button class="collapsed" data-toggle="collapse" data-target="#cOJ6"
                                        aria-expanded="false" aria-controls="cOJ6">
                                    Como acompanho o status da minha submissão pelo OJS?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cOJ6" class="collapse" aria-labelledby="hOJ6" data-parent="#accordionOJ">
                                <div class="card-body">
                                    <p>Acesse o OJS da revista com seu usuário e senha, entre no seu <strong>painel de autor(a)</strong> e localize a submissão na lista de trabalhos enviados. Ali é possível ver em qual etapa do fluxo editorial o artigo está (em avaliação, aguardando revisões, aceito, em produção ou publicado), além do histórico de mensagens trocadas com a equipe editorial.</p>
                                    <p style="margin-top:14px;">O sistema também envia e-mails automáticos sempre que houver uma mudança relevante de status — por isso, vale manter o e-mail cadastrado atualizado.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grupo: Fale Conosco / Equipe -->
                <div class="faq-group" data-cat="Atendimento">
                    <p class="faq-group-title"><span class="fg-icon">✉️</span> Atendimento e Equipe do Portal</p>
                    <div id="accordionFC">

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFC0">
                            <div class="card-header" id="hFC0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFC0"
                                        aria-expanded="false" aria-controls="cFC0">
                                    Como entrar em contato com o Portal?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFC0" class="collapse" aria-labelledby="hFC0" data-parent="#accordionFC">
                                <div class="card-body">
                                    <ul>
                                        <li><strong>Formulário eletrônico:</strong> use o <a href="#form-contato">formulário de contato</a> no final desta página.</li>
                                        <li><strong>E-mail:</strong> <a href="mailto:periodicos.ufpb@gmail.com">periodicos.ufpb@gmail.com</a></li>
                                        <li><strong>Endereço:</strong> Rua Alameda da Oiticica S/N, Campus I — Prédio da Editora Universitária da UFPB, João Pessoa/PB, CEP 58.051-970</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFC1">
                            <div class="card-header" id="hFC1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFC1"
                                        aria-expanded="false" aria-controls="cFC1">
                                    Quando devo entrar em contato com a equipe editorial da revista?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFC1" class="collapse" aria-labelledby="hFC1" data-parent="#accordionFC">
                                <div class="card-body">
                                    <p>Entre em contato diretamente com a equipe editorial quando a dúvida estiver relacionada à submissão, avaliação, decisão editorial, prazos, publicação ou outras questões específicas do processo editorial daquela revista.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFC2">
                            <div class="card-header" id="hFC2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFC2"
                                        aria-expanded="false" aria-controls="cFC2">
                                    Quando devo solicitar suporte ao Portal de Periódicos?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFC2" class="collapse" aria-labelledby="hFC2" data-parent="#accordionFC">
                                <div class="card-body">
                                    <p>O Portal deve ser acionado para questões relacionadas aos serviços e procedimentos sob sua responsabilidade, especialmente dúvidas ou problemas técnicos que não possam ser solucionados pela equipe editorial ou pelas orientações disponíveis nos manuais e guias.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="autores" data-target="#cFC3">
                            <div class="card-header" id="hFC3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cFC3"
                                        aria-expanded="false" aria-controls="cFC3">
                                    Qual é a equipe do Portal?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cFC3" class="collapse" aria-labelledby="hFC3" data-parent="#accordionFC">
                                <div class="card-body">
                                    <ul>
                                        <li>Ana Roberta Mota — <strong>Bibliotecária</strong></li>
                                        <li>Cassandra Campos — <strong>Editora de Publicações</strong></li>
                                        <li>Edilson de Melo Filho — <strong>Bibliotecário</strong></li>
                                        <li>Fabiana França — <strong>Bibliotecária</strong> (em licença)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </div><!-- /tab autores -->


    <!-- ===== ABA EDITORES ===== -->
    <div class="tab-pane fade" id="editores" role="tabpanel" aria-labelledby="editores-tab">

        <!-- Como hospedar -->
        <section class="ajuda-section">
            <div class="container">
                <p class="section-title">Perguntas Frequentes para Editores</p>
                <p class="section-subtitle">Requisitos, gestão da revista no OJS, indexação e serviços prestados pelo Portal.</p>

                <div class="faq-group" data-cat="Hospedagem e Ingresso">
                    <p class="faq-group-title"><span class="fg-icon">🏠</span> Hospedagem e Ingresso no Portal</p>
                    <div id="accordionHI">

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cHI0">
                            <div class="card-header" id="hHI0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cHI0"
                                        aria-expanded="false" aria-controls="cHI0">
                                    Documentos necessários para ingresso
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cHI0" class="collapse" aria-labelledby="hHI0" data-parent="#accordionHI">
                                <div class="card-body">
                                    <p>Para criar uma revista no Portal é necessário enviar à Coordenação dois documentos:</p>
                                    <p><strong>a) Documento de vínculo institucional</strong> — vincula a revista a um Departamento, Programa de Pós-Graduação ou Grupo de Pesquisa certificado pelo CNPq.</p>
                                    <p><strong>b) Projeto descritivo da revista</strong>, contendo:</p>
                                    <ul>
                                        <li>Nome e logotipo da revista</li>
                                        <li>Equipe editorial: Editores, Comissão Editorial, Conselho Consultivo e Suporte técnico</li>
                                        <li>Foco e escopo</li>
                                        <li>Periodicidade pretendida</li>
                                        <li>Diretrizes para autores (em conformidade com as normas ABNT)</li>
                                    </ul>
                                    <p>A solicitação de hospedagem deve seguir os procedimentos institucionais estabelecidos pelo Portal; consulte estas orientações e verifique a documentação atualizada antes de encaminhar o pedido. Envie a documentação pelo <a href="#form-contato">formulário de contato</a> ou para: <a href="mailto:periodicos.ufpb@gmail.com">periodicos.ufpb@gmail.com</a></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="faq-group" data-cat="Gestão no OJS">
                    <p class="faq-group-title"><span class="fg-icon">⚙️</span> Gestão da Revista no OJS</p>
                    <div id="accordionGO">

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cGO0">
                            <div class="card-header" id="hGO0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cGO0"
                                        aria-expanded="false" aria-controls="cGO0">
                                    Como alterar informações da revista no OJS?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cGO0" class="collapse" aria-labelledby="hGO0" data-parent="#accordionGO">
                                <div class="card-body">
                                    <p>As alterações nas configurações e informações da revista devem ser realizadas pela equipe editorial ou pelos usuários que possuem as permissões necessárias no OJS. Quando a alteração depender de suporte técnico ou de configuração sob responsabilidade do Portal, a equipe editorial deverá solicitar atendimento ao Portal.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cGO1">
                            <div class="card-header" id="hGO1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cGO1"
                                        aria-expanded="false" aria-controls="cGO1">
                                    Como cadastrar ou alterar funções de usuários no OJS?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cGO1" class="collapse" aria-labelledby="hGO1" data-parent="#accordionGO">
                                <div class="card-body">
                                    <p>O gerenciamento de funções e permissões depende do perfil administrativo disponível na revista. A equipe editorial deve verificar as permissões de seu usuário e, quando não puder realizar a alteração necessária, solicitar orientação ou suporte ao Portal.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cGO2">
                            <div class="card-header" id="hGO2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cGO2"
                                        aria-expanded="false" aria-controls="cGO2">
                                    O que fazer quando ocorre um erro no fluxo editorial da revista?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cGO2" class="collapse" aria-labelledby="hGO2" data-parent="#accordionGO">
                                <div class="card-body">
                                    <p>Primeiro, registre a ocorrência e verifique se o procedimento está de acordo com as orientações do OJS e com o fluxo editorial da revista. Persistindo o problema, encaminhe ao Portal as informações sobre a ocorrência — revista, usuário, etapa do processo, mensagem apresentada e captura de tela, quando disponível — pelo <a href="#form-contato">formulário de contato</a>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cGO3">
                            <div class="card-header" id="hGO3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cGO3"
                                        aria-expanded="false" aria-controls="cGO3">
                                    Como solicitar suporte para uma revista já hospedada no Portal?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cGO3" class="collapse" aria-labelledby="hGO3" data-parent="#accordionGO">
                                <div class="card-body">
                                    <p>A equipe editorial deve encaminhar a solicitação pelos canais de atendimento do Portal, descrevendo o problema ou a necessidade apresentada. É importante informar o nome da revista, o usuário envolvido, a etapa do processo e, quando aplicável, anexar capturas de tela ou mensagens de erro.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="faq-group" data-cat="DOI">
                    <p class="faq-group-title"><span class="fg-icon">🆔</span> DOI da Revista</p>
                    <div id="accordionDR">

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cDR0">
                            <div class="card-header" id="hDR0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cDR0"
                                        aria-expanded="false" aria-controls="cDR0">
                                    Como solicitar a atribuição de DOI para os artigos da revista?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cDR0" class="collapse" aria-labelledby="hDR0" data-parent="#accordionDR">
                                <div class="card-body">
                                    <p>A atribuição de DOI segue o fluxo institucional estabelecido pelo Portal. A equipe editorial deve observar os procedimentos e requisitos indicados no <strong>Guia Rápido DOI — Designação e Depósito</strong> e encaminhar as informações necessárias conforme as orientações vigentes.</p>
                                    <p>📄 O guia está disponível na aba <a href="#recursos" data-toggle="tab"><strong>Manuais, Guias e Tutoriais</strong></a>.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="faq-group" data-cat="Indexação">
                    <p class="faq-group-title"><span class="fg-icon">🔎</span> Indexação e Visibilidade</p>
                    <div id="accordionIV">

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cIV0">
                            <div class="card-header" id="hIV0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cIV0"
                                        aria-expanded="false" aria-controls="cIV0">
                                    Como cadastrar e preparar a revista para o Google Scholar?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cIV0" class="collapse" aria-labelledby="hIV0" data-parent="#accordionIV">
                                <div class="card-body">
                                    <p>O cadastro e a inclusão de uma revista dependem do atendimento aos requisitos técnicos e de indexação do Google Scholar. A equipe editorial deve verificar os requisitos e as orientações da plataforma e assegurar que os artigos estejam publicados com informações bibliográficas e metadados adequados.</p>
                                    <p>📚 Consulte o <strong>Guia de Cadastro no Google Scholar</strong> disponibilizado pelo Portal na aba <a href="#recursos" data-toggle="tab"><strong>Manuais, Guias e Tutoriais</strong></a>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cIV1">
                            <div class="card-header" id="hIV1">
                                <button class="collapsed" data-toggle="collapse" data-target="#cIV1"
                                        aria-expanded="false" aria-controls="cIV1">
                                    Por que um artigo ainda não aparece no Google Scholar?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cIV1" class="collapse" aria-labelledby="hIV1" data-parent="#accordionIV">
                                <div class="card-body">
                                    <p>A inclusão de artigos no Google Scholar não é imediata e depende dos processos de rastreamento e indexação realizados pela própria plataforma. É necessário também que a página do artigo esteja acessível e apresente metadados adequados.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cIV2">
                            <div class="card-header" id="hIV2">
                                <button class="collapsed" data-toggle="collapse" data-target="#cIV2"
                                        aria-expanded="false" aria-controls="cIV2">
                                    Como preparar minha revista para submissão ao DOAJ?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cIV2" class="collapse" aria-labelledby="hIV2" data-parent="#accordionIV">
                                <div class="card-body">
                                    <p>A equipe editorial deve verificar os critérios de inclusão do Directory of Open Access Journals (DOAJ) e preparar a revista de acordo com os requisitos estabelecidos. O Portal disponibiliza o <strong>Manual de Submissão ao DOAJ</strong> para auxiliar nesse processo, na aba <a href="#recursos" data-toggle="tab"><strong>Manuais, Guias e Tutoriais</strong></a>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cIV3">
                            <div class="card-header" id="hIV3">
                                <button class="collapsed" data-toggle="collapse" data-target="#cIV3"
                                        aria-expanded="false" aria-controls="cIV3">
                                    Como saber se uma revista está indexada em uma determinada base de dados?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cIV3" class="collapse" aria-labelledby="hIV3" data-parent="#accordionIV">
                                <div class="card-body">
                                    <p>A presença de uma revista em uma base deve ser verificada diretamente na própria base ou nas informações oficiais disponibilizadas pela revista. Os critérios e processos de avaliação são definidos por cada serviço de indexação, e não pelo Portal.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cIV4">
                            <div class="card-header" id="hIV4">
                                <button class="collapsed" data-toggle="collapse" data-target="#cIV4"
                                        aria-expanded="false" aria-controls="cIV4">
                                    Como acessar o Portal CAPES, Scopus, Web of Science e outras bases de dados?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cIV4" class="collapse" aria-labelledby="hIV4" data-parent="#accordionIV">
                                <div class="card-body">
                                    <p>O atendimento relacionado ao acesso às bases de dados é realizado pela <strong>Biblioteca Central da UFPB</strong>, por meio do serviço Fale com o Bibliotecário e dos canais oficiais de atendimento da Biblioteca.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cIV5">
                            <div class="card-header" id="hIV5">
                                <button class="collapsed" data-toggle="collapse" data-target="#cIV5"
                                        aria-expanded="false" aria-controls="cIV5">
                                    O Portal pode solicitar a inclusão de uma revista em uma base de dados?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cIV5" class="collapse" aria-labelledby="hIV5" data-parent="#accordionIV">
                                <div class="card-body">
                                    <p>Os processos de avaliação e inclusão são definidos pelas próprias bases e indexadores. O Portal pode orientar as equipes editoriais quanto aos requisitos e procedimentos disponíveis, mas a decisão de indexação é de responsabilidade da instituição responsável pela base.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cIV6">
                            <div class="card-header" id="hIV6">
                                <button class="collapsed" data-toggle="collapse" data-target="#cIV6"
                                        aria-expanded="false" aria-controls="cIV6">
                                    O que pode impedir a indexação de uma revista?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cIV6" class="collapse" aria-labelledby="hIV6" data-parent="#accordionIV">
                                <div class="card-body">
                                    <p>Cada indexador possui critérios próprios de avaliação. Entre os aspectos considerados podem estar a regularidade das publicações, qualidade e consistência dos metadados, identificação dos autores, políticas editoriais, qualidade dos artigos, transparência das informações e requisitos técnicos. A revista deve consultar os critérios específicos do indexador pretendido.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="faq-group" data-cat="Serviços do Portal">
                    <p class="faq-group-title"><span class="fg-icon">🛠️</span> Serviços Prestados pelo Portal aos Editores</p>
                    <div id="accordionSP">

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cSP0">
                            <div class="card-header" id="hSP0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cSP0"
                                        aria-expanded="false" aria-controls="cSP0">
                                    Quais serviços o Portal de Periódicos oferece às revistas?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cSP0" class="collapse" aria-labelledby="hSP0" data-parent="#accordionSP">
                                <div class="card-body">
                                    <ul>
                                        <li>Credenciamento e configuração inicial da revista no OJS</li>
                                        <li>Auxílio na indexação em bases de dados (DOAJ, Latindex, Scopus etc.)</li>
                                        <li>Suporte para inserção de números retrospectivos</li>
                                        <li>Capacitação e treinamentos na plataforma OJS</li>
                                        <li>Orientação sobre ética, boas práticas e normas editoriais</li>
                                        <li>Orientação sobre editais e fontes de financiamento</li>
                                        <li>Orientação e validação de DOI</li>
                                        <li>Orientação e cadastro de ORCID</li>
                                        <li>Auxílio na obtenção de ISSN junto ao IBICT</li>
                                        <li>Inclusão na rede de preservação digital CARINIANA (IBICT)</li>
                                        <li>Incubação de periódicos emergentes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="faq-group" data-cat="Recursos para Editores">
                    <p class="faq-group-title"><span class="fg-icon">📚</span> Recursos e Guias para Editores</p>
                    <div id="accordionRG">

                        <div class="faq-card card faq-search-item" data-tab="editores" data-target="#cRG0">
                            <div class="card-header" id="hRG0">
                                <button class="collapsed" data-toggle="collapse" data-target="#cRG0"
                                        aria-expanded="false" aria-controls="cRG0">
                                    Onde encontro os guias e manuais oficiais para editores?
                                    <span class="faq-icon">+</span>
                                </button>
                            </div>
                            <div id="cRG0" class="collapse" aria-labelledby="hRG0" data-parent="#accordionRG">
                                <div class="card-body">
                                    <p>O Portal disponibiliza guias oficiais do OJS (PKP e IBICT), o guia rápido de designação e depósito de DOI, manual de submissão ao DOAJ e guia de cadastro no Google Scholar.</p>
                                    <p>📚 Acesse todos esses materiais na aba <a href="#recursos" data-toggle="tab"><strong>Manuais, Guias e Tutoriais</strong></a>.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </div><!-- /tab editores -->


    <!-- ===== ABA INTEGRIDADE ACADÊMICA ===== -->
    <div class="tab-pane fade" id="integridade" role="tabpanel" aria-labelledby="integridade-tab">

        <section class="ajuda-section">
            <div class="container">
                <p class="section-title">Integridade Acadêmica e Científica</p>
                <p class="section-subtitle">
                    Diretrizes da UFPB sobre plágio, uso de inteligência artificial e boas práticas
                    na produção científica, conforme a
                    <a href="https://sig-arq.ufpb.br/arquivos/2025189036a9a38041387d66209cac73d/Resoluo_Consepe_n_57.2025.pdf"
                       target="_blank" rel="noopener">Resolução Consepe nº&nbsp;57/2025</a>,
                    em âmbito nacional, a
                    <a href="http://memoria2.cnpq.br/web/guest/view/-/journal_content/56_INSTANCE_0oED/10157/23142775"
                       target="_blank" rel="noopener">Política de Integridade na Atividade Científica do CNPq</a>
                    e a
                    <a href="https://www.planalto.gov.br/ccivil_03/leis/l9610.htm"
                       target="_blank" rel="noopener">Lei de Direitos Autorais</a> (Lei nº&nbsp;9.610/98).
                </p>

                <div class="faq-group" data-cat="Integridade Acadêmica">
                <div id="accordionIntegridade">

                    <!-- 1. O que é plágio -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI0">
                        <div class="card-header" id="hI0">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI0"
                                    aria-expanded="false" aria-controls="cI0">
                                O que é plágio acadêmico?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI0" class="collapse" aria-labelledby="hI0" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>É a <strong>apropriação indevida da produção intelectual de outra pessoa sem o devido crédito à fonte</strong> (Art. 1º, §1º da Resolução Consepe nº&nbsp;57/2025).</p>
                                <p>Essa apropriação indevida pode ocorrer em qualquer etapa de um trabalho acadêmico, científico, tecnológico ou de extensão — na concepção, na execução, na análise de dados, na avaliação por pares ou na divulgação e publicação — e <strong>não se limita a quem tem vínculo formal com a UFPB</strong>. As diretrizes de integridade alcançam:</p>
                                <ul>
                                    <li>Discentes, docentes, servidores técnico-administrativos e colaboradores(as) vinculados(as) à UFPB;</li>
                                    <li>Autores(as) externos(as) que submetem trabalhos às revistas do Portal, mesmo sem vínculo institucional com a UFPB;</li>
                                    <li>Avaliadores(as), pareceristas e demais pessoas envolvidas na produção, execução ou avaliação do conteúdo.</li>
                                </ul>
                                <p style="margin-top:14px;">Esse entendimento mais amplo acompanha diretrizes nacionais de integridade científica, como a <a href="http://memoria2.cnpq.br/web/guest/view/-/journal_content/56_INSTANCE_0oED/10157/23142775" target="_blank" rel="noopener">Política de Integridade na Atividade Científica do CNPq</a>.</p>
                                <div class="aviso-integridade" style="margin-top:14px;">
                                    ⚖️ No Brasil, o plágio é considerado violação de direitos autorais e é tratado como crime, conforme a <a href="https://www.planalto.gov.br/ccivil_03/leis/l9610.htm" target="_blank" rel="noopener">Lei de Direitos Autorais</a> (Lei nº&nbsp;9.610/98) e o Código Penal.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. O que NÃO é plágio -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI1">
                        <div class="card-header" id="hI1">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI1"
                                    aria-expanded="false" aria-controls="cI1">
                                O que não é considerado plágio ou autoplágio?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI1" class="collapse" aria-labelledby="hI1" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>Conforme o Art. 1º, §2º da Resolução Consepe nº&nbsp;57/2025, não configuram plágio:</p>
                                <ul>
                                    <li>A republicação de texto com indicação expressa da publicação anterior;</li>
                                    <li>A atualização ou ampliação de texto anteriormente publicado;</li>
                                    <li>A utilização de método anteriormente desenvolvido em pesquisa posterior, com o devido crédito;</li>
                                    <li>O desenvolvimento e ampliação de trabalhos produzidos em atividades da UFPB aproveitados em trabalhos de conclusão, inclusive em coautoria com o(a) orientador(a);</li>
                                    <li>A publicação posterior, no todo ou em parte, em periódicos ou livros, de trabalho de conclusão.</li>
                                </ul>
                                <p style="margin-top:14px;">Essas exceções acompanham o entendimento geral da <a href="https://www.planalto.gov.br/ccivil_03/leis/l9610.htm" target="_blank" rel="noopener">Lei de Direitos Autorais</a> (Lei nº&nbsp;9.610/98) de que a citação com o devido crédito à fonte não configura violação de direitos autorais.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. IA -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI2">
                        <div class="card-header" id="hI2">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI2"
                                    aria-expanded="false" aria-controls="cI2">
                                Como posso usar ferramentas de Inteligência Artificial (IA) no meu trabalho?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI2" class="collapse" aria-labelledby="hI2" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>O uso de IA é <strong>autorizado como apoio</strong> nas seguintes etapas (Art. 2º da Resolução Consepe nº&nbsp;57/2025): ideação, busca e organização da literatura, leitura e síntese, revisão linguística, transcrição, tradução, formatação, programação e visualização de dados.</p>

                                <p><strong>É obrigatório:</strong></p>
                                <ul>
                                    <li>Indicar explicitamente a ferramenta utilizada, com versão e finalidade, sempre que o uso ultrapassar a revisão linguística ou ortográfica;</li>
                                    <li>Validar integralmente o conteúdo gerado, incluindo exatidão, coerência metodológica e conformidade das fontes e citações;</li>
                                    <li>Garantir a originalidade do trabalho e o respeito aos direitos autorais;</li>
                                    <li>Certificar que todas as referências correspondem a obras efetivamente consultadas pelo(a) autor(a).</li>
                                </ul>

                                <p><strong>É vedado:</strong></p>
                                <ul>
                                    <li>Reproduzir textos gerados por IA que resultem em mascaramento de autoria;</li>
                                    <li>Falsificar dados ou praticar qualquer mascaramento de autoria;</li>
                                    <li>Enviar dados inéditos, sensíveis ou identificáveis a sistemas de IA sem salvaguarda contratual formal de confidencialidade;</li>
                                    <li>Substituir o raciocínio humano, a autoria e o método científico por IA em qualquer fase do trabalho.</li>
                                </ul>

                                <div class="aviso-integridade">
                                    ⚠️ A omissão da utilização de ferramentas de IA, ou seu uso indevido, pode configurar infração ética (Art. 2º, §3º da Resolução Consepe nº&nbsp;57/2025).
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Similaridade -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI3">
                        <div class="card-header" id="hI3">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI3"
                                    aria-expanded="false" aria-controls="cI3">
                                O que significam os percentuais de similaridade?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI3" class="collapse" aria-labelledby="hI3" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>O relatório de similaridade, por si só, <strong>não determina a ocorrência de plágio</strong> — serve como indício para orientar a análise (Art. 5º, §2º da Resolução Consepe nº&nbsp;57/2025). Os percentuais são interpretados conforme abaixo (Art. 6º da mesma resolução):</p>
                                <div class="table-responsive-wrap" role="region" aria-label="Tabela de percentuais de similaridade">
                                <table class="similaridade-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Percentual</th>
                                            <th scope="col">Classificação</th>
                                            <th scope="col">Providência</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Até 10%</strong></td>
                                            <td><span class="badge-nivel badge-ok">Aceitável</span></td>
                                            <td>Passível de aprovação</td>
                                        </tr>
                                        <tr>
                                            <td><strong>10,1% – 30%</strong></td>
                                            <td><span class="badge-nivel badge-warn">Atenção</span></td>
                                            <td>Revisão textual obrigatória e reapresentação para nova verificação</td>
                                        </tr>
                                        <tr>
                                            <td><strong>30,1% – 50%</strong></td>
                                            <td><span class="badge-nivel badge-grave">Grave</span></td>
                                            <td>Reescrita substancial obrigatória</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Acima de 50%</strong></td>
                                            <td><span class="badge-nivel badge-crit">Indício crítico</span></td>
                                            <td>Análise e parecer conclusivo da CIAC</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Denúncia -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI4">
                        <div class="card-header" id="hI4">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI4"
                                    aria-expanded="false" aria-controls="cI4">
                                Como é feita uma denúncia de plágio?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI4" class="collapse" aria-labelledby="hI4" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>Qualquer membro da comunidade interna ou externa da UFPB pode formalizar uma denúncia à <strong>Comissão de Integridade Acadêmica do Centro (CIAC)</strong> à qual o(a) autor(a) principal está vinculado(a) (Art. 8º da Resolução Consepe nº&nbsp;57/2025).</p>
                                <p>O processo segue as seguintes etapas:</p>
                                <ol>
                                    <li>Recebimento da denúncia pela CIAC;</li>
                                    <li>Análise preliminar e verificação de conflito de interesses (prazo: 5 dias);</li>
                                    <li>Notificação dos(as) denunciados(as) para manifestação (prazo: 10 dias);</li>
                                    <li>Elaboração de relatório circunstanciado (prazo máximo: 60 dias, prorrogável);</li>
                                    <li>Apreciação pelo Conselho de Centro, com possibilidade de recurso ao Consepe.</li>
                                </ol>
                                <p>São garantidos em todas as etapas o <strong>contraditório</strong> e a <strong>ampla defesa</strong>, além da confidencialidade do processo (Art. 8º, §§9º e 10 da mesma resolução).</p>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Sanções -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI5">
                        <div class="card-header" id="hI5">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI5"
                                    aria-expanded="false" aria-controls="cI5">
                                Quais são as sanções previstas para casos de plágio?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI5" class="collapse" aria-labelledby="hI5" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>Verificada a procedência da denúncia, as sanções podem ser aplicadas de forma isolada ou cumulativa, considerando gravidade, intencionalidade, extensão do dano e retratação (Art. 12 da Resolução Consepe nº&nbsp;57/2025):</p>
                                <ul>
                                    <li>Despublicação de trabalhos em bases e periódicos institucionais;</li>
                                    <li>Recomendação de retratação e despublicação a periódicos ou editoras científicas;</li>
                                    <li>Cancelamento de agendamento de qualificação ou defesa;</li>
                                    <li>Anulação de defesa e cassação de diploma, quando cabível;</li>
                                    <li>Procedimentos administrativos-disciplinares a servidores(as).</li>
                                </ul>
                                <p>O cometimento não intencional do plágio e eventual retratação são considerados na determinação das sanções (Art. 12, §§1º e 2º da mesma resolução).</p>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Documento completo -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI6">
                        <div class="card-header" id="hI6">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI6"
                                    aria-expanded="false" aria-controls="cI6">
                                Quais documentos fundamentam a integridade acadêmica no Portal?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI6" class="collapse" aria-labelledby="hI6" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>As orientações desta seção se baseiam em três documentos:</p>
                                <ul>
                                    <li><strong>Resolução Consepe nº&nbsp;57/2025</strong> — regulamenta a Política de Integridade Acadêmica e Científica da UFPB, aprovada em 17 de setembro de 2025: define plágio, uso de inteligência artificial, apuração de denúncias e sanções.</li>
                                    <li><strong>Política de Integridade na Atividade Científica do CNPq</strong> (Portaria CNPq nº&nbsp;2.664/2026) — diretrizes nacionais que orientam o entendimento mais amplo de plágio adotado pelo Portal, alcançando também autores(as) e avaliadores(as) sem vínculo institucional com a UFPB.</li>
                                    <li><strong>Lei de Direitos Autorais</strong> (Lei nº&nbsp;9.610/98) — legislação federal que trata da proteção aos direitos autorais no Brasil e fundamenta o tratamento do plágio como violação desses direitos.</li>
                                </ul>
                                <p style="margin-top:16px;">📄 Os três documentos podem ser acessados diretamente pelos cartões logo abaixo destas perguntas.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 8. Deveres do autor (CNPq) -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI7">
                        <div class="card-header" id="hI7">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI7"
                                    aria-expanded="false" aria-controls="cI7">
                                Quais são os deveres do(a) autor(a) ao publicar um trabalho científico?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI7" class="collapse" aria-labelledby="hI7" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>A Política de Integridade na Atividade Científica do CNPq (Art.&nbsp;9º, II) estabelece deveres específicos para quem publica um trabalho científico:</p>
                                <ul>
                                    <li>Creditar adequadamente todas as fontes utilizadas;</li>
                                    <li>Indicar citações literais mediante aspas e referências;</li>
                                    <li>Informar caso o conteúdo já tenha sido divulgado anteriormente (por exemplo, em preprint ou evento);</li>
                                    <li>Evitar a fragmentação injustificada dos resultados em várias publicações;</li>
                                    <li>Identificar trabalhos anteriores do(a) próprio(a) autor(a), prevenindo o autoplágio;</li>
                                    <li>Definir claramente as responsabilidades de autoria desde o início da pesquisa;</li>
                                    <li>Não incluir como autor(a) quem não teve contribuição efetiva para o trabalho.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 9. Conflito de interesses (CNPq) -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI8">
                        <div class="card-header" id="hI8">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI8"
                                    aria-expanded="false" aria-controls="cI8">
                                O que pode caracterizar um conflito de interesses na avaliação de um trabalho?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI8" class="collapse" aria-labelledby="hI8" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>Conforme o Art.&nbsp;7º, V da Política de Integridade do CNPq, configuram conflito de interesses situações como:</p>
                                <ul>
                                    <li>Vínculo de parentesco com o(a) autor(a) até o terceiro grau;</li>
                                    <li>Vínculo institucional direto com o(a) autor(a) ou com a instituição de origem do trabalho;</li>
                                    <li>Relação de orientação acadêmica anterior entre avaliador(a) e autor(a);</li>
                                    <li>Motivações pessoais que possam comprometer a imparcialidade da avaliação.</li>
                                </ul>
                                <p>Avaliadores(as) e pareceristas devem se identificar e se afastar da avaliação sempre que perceberem alguma dessas situações.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 10. Outras condutas (CNPq) -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI9">
                        <div class="card-header" id="hI9">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI9"
                                    aria-expanded="false" aria-controls="cI9">
                                Além do plágio, quais outras condutas são consideradas má conduta científica?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI9" class="collapse" aria-labelledby="hI9" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>Além do plágio (já tratado na primeira pergunta desta seção), o Art.&nbsp;5º da Política de Integridade do CNPq também classifica como má conduta científica:</p>
                                <ul>
                                    <li><strong>Fabricação ou falsificação de dados</strong> — apresentação de resultados inverídicos ou manipulação fraudulenta de dados de pesquisa (incisos XI e XII);</li>
                                    <li><strong>Fragmentação indevida</strong> — divisão artificial dos resultados de uma mesma pesquisa em várias publicações apenas para aumentar o número de trabalhos publicados (inciso XX);</li>
                                    <li><strong>Autoplágio</strong> — publicação total ou parcial de um texto já publicado pelo(a) mesmo(a) autor(a), sem referência à publicação anterior (inciso II).</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 11. Consequências nacionais (CNPq) -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI10">
                        <div class="card-header" id="hI10">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI10"
                                    aria-expanded="false" aria-controls="cI10">
                                Uma má conduta comprovada pode ter consequências além das sanções da UFPB?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI10" class="collapse" aria-labelledby="hI10" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>Sim. Além do processo interno conduzido pela CIAC e pelo Conselho de Centro (já detalhado nesta aba), a Política de Integridade do CNPq prevê consequências em âmbito nacional para quem recebe apoio do CNPq, como bolsas e financiamentos. O Art.&nbsp;33 classifica o plágio, a fabricação e a falsificação de dados como infrações gravíssimas, e o Art.&nbsp;34 da mesma política prevê sanções que variam conforme a gravidade:</p>
                                <ul>
                                    <li>Advertência formal;</li>
                                    <li>Suspensão de bolsas;</li>
                                    <li>Impedimento de participar de processos seletivos do CNPq;</li>
                                    <li>Suspensão do Currículo Lattes, de três meses a um ano;</li>
                                    <li>Revogação do fomento concedido.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 12. O que a lei protege (Lei 9.610/98) -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI11">
                        <div class="card-header" id="hI11">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI11"
                                    aria-expanded="false" aria-controls="cI11">
                                O que a Lei de Direitos Autorais protege — e o que ela não protege?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI11" class="collapse" aria-labelledby="hI11" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>O Art.&nbsp;7º da Lei de Direitos Autorais (Lei nº&nbsp;9.610/98) protege as "criações do espírito, expressas por qualquer meio ou fixadas em qualquer suporte" — o que inclui textos científicos, compilações e bases de dados, entre outras obras.</p>
                                <p style="margin-top:14px;">Já o Art.&nbsp;8º da mesma lei esclarece o que <strong>não</strong> é protegido por direitos autorais: ideias, procedimentos, métodos, sistemas e conceitos matemáticos em si. Ou seja, a lei protege a forma como um conteúdo é expresso — o texto, a redação —, não a ideia ou o método científico em si. É por isso que citar corretamente a fonte de uma ideia é uma questão de integridade acadêmica, mesmo quando, tecnicamente, não é uma exigência da lei de direitos autorais.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 13. Direitos morais (Lei 9.610/98) -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI12">
                        <div class="card-header" id="hI12">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI12"
                                    aria-expanded="false" aria-controls="cI12">
                                O que são os direitos morais do autor, e eles podem ser cedidos ou vendidos?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI12" class="collapse" aria-labelledby="hI12" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>O Art.&nbsp;24 da Lei de Direitos Autorais garante ao(à) autor(a) uma série de direitos morais, entre eles: reivindicar a autoria da obra a qualquer tempo, ter seu nome indicado sempre que a obra for utilizada, e assegurar a integridade da obra, opondo-se a modificações que possam prejudicá-la.</p>
                                <p style="margin-top:14px;">Segundo o Art.&nbsp;27 da mesma lei, esses direitos morais são <strong>inalienáveis e irrenunciáveis</strong> — ou seja, o(a) autor(a) não pode abrir mão deles nem transferi-los a terceiros, mesmo ao publicar em uma revista ou sob uma licença de acesso aberto.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 14. Citação sem autorização (Lei 9.610/98) -->
                    <div class="faq-card card faq-search-item" data-tab="integridade" data-target="#cI13">
                        <div class="card-header" id="hI13">
                            <button class="collapsed" data-toggle="collapse" data-target="#cI13"
                                    aria-expanded="false" aria-controls="cI13">
                                É permitido citar trechos de uma obra sem pedir autorização do autor?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cI13" class="collapse" aria-labelledby="hI13" data-parent="#accordionIntegridade">
                            <div class="card-body">
                                <p>Sim. O Art.&nbsp;46, III da Lei de Direitos Autorais permite a citação de passagens de qualquer obra em livros, jornais e revistas "para fins de estudo, crítica ou polêmica, na medida justificada", sem necessidade de autorização do(a) autor(a) original.</p>
                                <p style="margin-top:14px;">Essa previsão legal é a base de uma prática comum e esperada na produção científica: citar e comentar o trabalho de outros pesquisadores, desde que a fonte seja devidamente referenciada. É exatamente essa exigência de crédito à fonte que, quando ausente, caracteriza o plágio (veja a primeira pergunta desta aba).</p>
                            </div>
                        </div>
                    </div>

                </div><!-- /accordionIntegridade -->
                </div>

                <div class="row" style="margin-top:8px;">

                    <div class="col-md-4 mb-4">
                        <div class="info-card">
                            <div class="ic-icon">⚖️</div>
                            <h4>Resolução Consepe nº 57/2025</h4>
                            <p>Regulamenta a Política de Integridade Acadêmica e Científica da UFPB: define plágio, uso de inteligência artificial, apuração de denúncias e sanções.</p>
                            <a href="https://sig-arq.ufpb.br/arquivos/2025189036a9a38041387d66209cac73d/Resoluo_Consepe_n_57.2025.pdf" target="_blank" rel="noopener"
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                Acessar PDF
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="info-card">
                            <div class="ic-icon">🔬</div>
                            <h4>Política de Integridade do CNPq</h4>
                            <p>Diretrizes nacionais de integridade na atividade científica, que orientam o entendimento mais amplo de plágio e boas práticas adotado pelo Portal.</p>
                            <a href="http://memoria2.cnpq.br/web/guest/view/-/journal_content/56_INSTANCE_0oED/10157/23142775" target="_blank" rel="noopener"
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                Acessar documento
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="info-card">
                            <div class="ic-icon">📜</div>
                            <h4>Lei de Direitos Autorais (Lei nº 9.610/98)</h4>
                            <p>Legislação federal que trata da proteção aos direitos autorais no Brasil e fundamenta o tratamento do plágio como violação desses direitos.</p>
                            <a href="https://www.planalto.gov.br/ccivil_03/leis/l9610.htm" target="_blank" rel="noopener"
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                Acessar lei
                            </a>
                        </div>
                    </div>

                </div><!-- /row documentos de referência -->

            </div>
        </section>

    </div><!-- /tab integridade -->


    <!-- ===== ABA RECURSOS E DOWNLOADS ===== -->
    <div class="tab-pane fade" id="recursos" role="tabpanel" aria-labelledby="recursos-tab">

        <section class="ajuda-section">
            <div class="container">
                <p class="section-title">Central de Manuais, Guias e Tutoriais</p>
                <p class="section-subtitle">Todos os manuais, guias e documentos oficiais do Portal reunidos em um só lugar, sem precisar procurar dentro das perguntas frequentes.</p>

                <div class="row">

                    <div class="col-md-4 mb-4">
                        <div id="res-manual-metadados" class="info-card faq-search-item" data-tab="recursos" data-target="#res-manual-metadados">
                            <div class="ic-icon">📄</div>
                            <h4>Manual de Metadados OJS</h4>
                            <p>Boas práticas para preencher corretamente títulos, autores, afiliações, resumos e palavras-chave no sistema OJS.</p>
                            <a href="Manual_Metadados_OJS.pdf" download
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                ⬇️ Baixar PDF
                            </a>
                        </div>
                    </div>
<div class="col-md-4 mb-4">
    <div id="res-manual-editor" class="info-card faq-search-item" data-tab="recursos" data-target="#res-manual-editor">
        <div class="ic-icon">🖋️</div>
        <span class="card-audience-tag">Para Editores</span>
        <h4>Manual do Editor</h4>
        <p>Numeração de volumes, fascículos e suplementos, cadastro e configuração do periódico no OJS (incluindo dados em inglês e DOI) e preenchimento correto dos metadados, conforme a ABNT NBR 6021:2015.</p>
        <a href="Manual_do_Editor.pdf" download
           style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
            ⬇️ Baixar PDF
        </a>
    </div>
</div>
                    <div class="col-md-4 mb-4">
                        <div id="res-doi" class="info-card faq-search-item" data-tab="recursos" data-target="#res-doi">
                            <div class="ic-icon">🆔</div>
                            <span class="card-audience-tag">Para Editores</span>
                            <h4>Guia Rápido: DOI — Designação e Depósito</h4>
                            <p>Como funciona o DOI na aba Identificadores do OJS: passo a passo para designar o identificador e as diferenças entre depósito com contrato próprio e institucional junto à Crossref.</p>
                            <a href="Guia_DOI_Designacao_Deposito.pdf" download
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                ⬇️ Baixar PDF
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div id="res-doaj" class="info-card faq-search-item" data-tab="recursos" data-target="#res-doaj">
                            <div class="ic-icon">📚</div>
                            <span class="card-audience-tag">Para Editores</span>
                            <h4>Manual de Submissão ao DOAJ</h4>
                            <p>Passo a passo para indexação da revista no Directory of Open Access Journals (DOAJ).</p>
                            <a href="Manual_DOAJ.pdf" download
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                ⬇️ Baixar PDF
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div id="res-google-scholar" class="info-card faq-search-item" data-tab="recursos" data-target="#res-google-scholar">
                            <div class="ic-icon">🎓</div>
                            <span class="card-audience-tag">Para Editores</span>
                            <h4>Guia de Cadastro no Google Scholar</h4>
                            <p>Como cadastrar a revista e configurar o perfil para acompanhamento do índice de citações no Google Scholar.</p>
                            <a href="Guia_Cadastro_Google_Scholar.pdf" download
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                ⬇️ Baixar PDF
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div id="res-ojs-pkp" class="info-card faq-search-item" data-tab="recursos" data-target="#res-ojs-pkp">
                            <div class="ic-icon">📘</div>
                            <h4>Guia OJS 3.3 — Documentação Oficial</h4>
                            <p>Manual completo do Public Knowledge Project (PKP) em português: configuração, fluxo editorial, avaliação por pares e publicação.</p>
                            <a href="https://docs.pkp.sfu.ca/learning-ojs/3.3/pt/" target="_blank"
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                Acessar guia
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div id="res-ojs-ibict" class="info-card faq-search-item" data-tab="recursos" data-target="#res-ojs-ibict">
                            <div class="ic-icon">📄</div>
                            <h4>Manual OJS 3 — IBICT</h4>
                            <p>Adaptação do manual oficial para o contexto das universidades brasileiras, desenvolvido pelo IBICT com foco na língua portuguesa.</p>
                            <a href="https://drive.google.com/file/d/1EsTxRoMKsa7LoZ9aZPmGF2QLOZIyHSy9/view?usp=sharing" target="_blank"
                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                Acessar PDF
                            </a>
                        </div>
                    </div>

                </div><!-- /row -->
            </div>
        </section>

    </div><!-- /tab recursos -->

</div><!-- /tab-content -->

<!-- Contact -->
<section id="contato-ajuda">
    <div class="container contato-content">
        <h2>Ainda tem dúvidas?</h2>
        <p>Não encontrou o que precisava nas perguntas frequentes? Fale com a equipe do Portal de Periódicos da UFPB.</p>
        <div>
            <a class="contact-pill" href="mailto:periodicos.ufpb@gmail.com">
                ✉️ <span><strong>periodicos.ufpb@gmail.com</strong></span>
            </a>
            <span class="contact-pill" style="cursor:default;">
                📍 <span>Editora Universitária da UFPB — Campus I, João Pessoa/PB</span>
            </span>
        </div>

        <div class="contato-form-card" id="form-contato">
            <h3>Envie sua mensagem</h3>
            <p class="form-lead">Preencha o formulário abaixo — sua mensagem será enviada diretamente para o e-mail do Portal e respondida o quanto antes.</p>

            <?php if ($formStatus === 'success'): ?>
                <div class="form-alert form-alert-success" role="status">
                    ✅ Mensagem enviada com sucesso! Nossa equipe vai responder no e-mail informado em breve.
                </div>
            <?php elseif ($formStatus === 'error'): ?>
                <div class="form-alert form-alert-error" role="alert">
                    ⚠️ Não foi possível enviar sua mensagem.
                    <?php if (!empty($formErrors)): ?>
                        <ul>
                            <?php foreach ($formErrors as $e): ?>
                                <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        Tente novamente em instantes ou escreva diretamente para
                        <a href="mailto:periodicos.ufpb@gmail.com">periodicos.ufpb@gmail.com</a>.
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <form action="#form-contato" method="post" enctype="multipart/form-data" novalidate>
                <div class="form-cols">
                    <div class="form-row">
                        <label for="ct-nome">Nome*</label>
                        <input type="text" id="ct-nome" name="nome" required
                               value="<?php echo htmlspecialchars($old['nome'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="form-row">
                        <label for="ct-email">E-mail*</label>
                        <input type="email" id="ct-email" name="email" required
                               value="<?php echo htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <label for="ct-revista">Revista (opcional)</label>
                    <input type="text" id="ct-revista" name="revista"
                           value="<?php echo htmlspecialchars($old['revista'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-row">
                    <label for="ct-assunto">Assunto</label>
                    <select id="ct-assunto" name="assunto">
                        <option value="">Selecione um assunto (opcional)</option>
                        <option>Cadastro e acesso</option>
                        <option>Submissão de artigo</option>
                        <option>Avaliação por pares</option>
                        <option>Metadados e ORCID</option>
                        <option>DOI</option>
                        <option>Hospedagem de revista</option>
                        <option>Indexação (DOAJ, Google Scholar, bases)</option>
                        <option>Integridade acadêmica</option>
                        <option>Outro assunto</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="ct-mensagem">Mensagem*</label>
                    <textarea id="ct-mensagem" name="mensagem" rows="5" required><?php echo htmlspecialchars($old['mensagem'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="form-row">
                    <label for="ct-anexo">Anexar arquivo (opcional)</label>
                    <input type="file" id="ct-anexo" name="anexo" class="form-file"
                           accept=".pdf,.doc,.docx,.odt,.jpg,.jpeg,.png,.zip">
                    <p class="form-hint">PDF, DOC, DOCX, ODT, JPG, PNG ou ZIP — até 8MB. Use para prints de erro, comprovantes ou documentos citados na mensagem.</p>
                    <p class="form-hint form-hint-error" id="ct-anexo-erro" hidden></p>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo ANEXO_TAMANHO_MAXIMO; ?>">

                <!-- Campo-armadilha anti-spam: deve permanecer vazio -->
                <div class="hp-field" aria-hidden="true">
                    <label for="site_url">Deixe este campo em branco</label>
                    <input type="text" id="site_url" name="site_url" tabindex="-1" autocomplete="off">
                </div>
                <input type="hidden" name="form_ts" value="<?php echo time(); ?>">

                <button type="submit" name="ajuda_contato_submit" value="1" class="btn-enviar">Enviar mensagem</button>
            </form>
        </div>
    </div>
</section>

<?php include 'footer.html'; ?>

<script>
(function () {
    'use strict';

    function normalizar(texto) {
        return (texto || '')
            .toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();
    }

    function textoDe(el, seletores) {
        for (var i = 0; i < seletores.length; i++) {
            var alvo = el.querySelector(seletores[i]);
            if (alvo && alvo.textContent.trim()) {
                return alvo.textContent.replace(/\s+/g, ' ').trim();
            }
        }
        return '';
    }

    // ---- Índice de busca ----
    var itens = [];
    document.querySelectorAll('.faq-search-item').forEach(function (el) {
        var pergunta = textoDe(el, ['.card-header button', 'h4']);
        // remove o "+" do ícone do acordeão, se capturado junto
        pergunta = pergunta.replace(/\+\s*$/, '').trim();
        var resposta = textoDe(el, ['.card-body', 'p']);
        var grupo = el.closest('.faq-group');
        var categoria = grupo ? (grupo.getAttribute('data-cat') || '') : '';

        itens.push({
            tab: el.getAttribute('data-tab'),
            target: el.getAttribute('data-target'),
            pergunta: pergunta,
            categoria: categoria,
            textoBusca: normalizar(pergunta + ' ' + resposta + ' ' + categoria)
        });
    });

    function irParaItem(tabId, targetSel) {
        if (tabId) {
            var tabLink = document.getElementById(tabId + '-tab');
            if (tabLink) { tabLink.click(); }
        }
        setTimeout(function () {
            if (!targetSel) { return; }
            var el = document.querySelector(targetSel);
            if (!el) { return; }
            var scrollAlvo = el;

            if (el.classList.contains('collapse')) {
                var btn = document.querySelector('[data-target="' + targetSel + '"]');
                if (btn && btn.getAttribute('aria-expanded') !== 'true') {
                    btn.click();
                }
                scrollAlvo = btn ? btn.closest('.faq-card') : el;
            }

            setTimeout(function () {
                scrollAlvo.scrollIntoView({ behavior: 'smooth', block: 'center' });
                scrollAlvo.classList.add('busca-destaque');
                setTimeout(function () {
                    scrollAlvo.classList.remove('busca-destaque');
                }, 2200);
            }, 350);
        }, 150);
    }

    function configurarBusca(inputId, resultadosId) {
        var input = document.getElementById(inputId);
        var resultados = document.getElementById(resultadosId);
        if (!input || !resultados) { return; }

        function fechar() {
            resultados.hidden = true;
            resultados.innerHTML = '';
        }

        function renderizar(lista, termo) {
            if (!lista.length) {
                resultados.innerHTML =
                    '<div class="busca-vazio">Nenhum resultado para "<strong>' +
                    termo.replace(/</g, '&lt;') +
                    '</strong>".<br>Tente outra palavra ou ' +
                    '<a href="#form-contato" data-fechar-busca="1">fale com a nossa equipe</a>.</div>';
                resultados.hidden = false;
                return;
            }
            var html = lista.slice(0, 8).map(function (item) {
                return '<button type="button" class="busca-item" data-tab="' + item.tab +
                    '" data-target="' + item.target + '">' +
                    '<span class="busca-pergunta">' + item.pergunta.replace(/</g, '&lt;') + '</span>' +
                    (item.categoria ? '<span class="busca-cat">' + item.categoria.replace(/</g, '&lt;') + '</span>' : '') +
                    '</button>';
            }).join('');
            resultados.innerHTML = html;
            resultados.hidden = false;
        }

        input.addEventListener('input', function () {
            var termo = input.value.trim();
            if (termo.length < 2) { fechar(); return; }
            var termoNorm = normalizar(termo);
            var lista = itens.filter(function (it) {
                return it.textoBusca.indexOf(termoNorm) !== -1;
            });
            renderizar(lista, termo);
        });

        resultados.addEventListener('click', function (e) {
            var btn = e.target.closest('.busca-item');
            if (btn) {
                irParaItem(btn.getAttribute('data-tab'), btn.getAttribute('data-target'));
                fechar();
                input.value = '';
                return;
            }
            if (e.target.closest('[data-fechar-busca]')) {
                fechar();
                input.value = '';
            }
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#' + inputId) && !e.target.closest('#' + resultadosId)) {
                fechar();
            }
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { fechar(); input.blur(); }
        });
    }

    configurarBusca('buscaAjuda', 'buscaResultados');

    // Deep-link opcional: acessar a página com #faq-cCA0 abre e rola até o item
    if (window.location.hash && window.location.hash.indexOf('#faq-') === 0) {
        var alvo = '#' + window.location.hash.replace('#faq-', '');
        var card = document.querySelector('[data-target="' + alvo + '"].faq-search-item');
        if (card) {
            var pane = card.closest('.tab-pane');
            irParaItem(pane ? pane.id : null, alvo);
        }
    }

    // Após o envio do formulário (sucesso ou erro), rola até o card para mostrar o aviso
    var alertaForm = document.querySelector('.form-alert');
    if (alertaForm) {
        setTimeout(function () {
            document.getElementById('form-contato').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 150);
    }

    // Validação amigável do anexo (tamanho e formato) antes de enviar
    var campoAnexo = document.getElementById('ct-anexo');
    var avisoAnexo = document.getElementById('ct-anexo-erro');
    var formularioContato = document.querySelector('#form-contato form');
    if (campoAnexo && avisoAnexo && formularioContato) {
        var extensoesPermitidas = ['pdf', 'doc', 'docx', 'odt', 'jpg', 'jpeg', 'png', 'zip'];
        var tamanhoMaximo = parseInt(formularioContato.querySelector('[name="MAX_FILE_SIZE"]').value, 10) || (8 * 1024 * 1024);

        function validarAnexo() {
            avisoAnexo.hidden = true;
            avisoAnexo.textContent = '';
            if (!campoAnexo.files || !campoAnexo.files[0]) { return true; }
            var arquivo = campoAnexo.files[0];
            var extensao = arquivo.name.split('.').pop().toLowerCase();
            if (extensoesPermitidas.indexOf(extensao) === -1) {
                avisoAnexo.textContent = 'Formato não permitido. Use PDF, DOC, DOCX, ODT, JPG, PNG ou ZIP.';
                avisoAnexo.hidden = false;
                return false;
            }
            if (arquivo.size > tamanhoMaximo) {
                avisoAnexo.textContent = 'Arquivo muito grande (máximo 8MB).';
                avisoAnexo.hidden = false;
                return false;
            }
            return true;
        }

        campoAnexo.addEventListener('change', validarAnexo);
        formularioContato.addEventListener('submit', function (e) {
            if (!validarAnexo()) {
                e.preventDefault();
                avisoAnexo.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }
})();
</script>
