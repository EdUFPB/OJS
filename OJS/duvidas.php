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
.faq-card .card-body ul {
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
    padding: 60px 0 52px;
    text-align: center;
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
}
#contato-ajuda h2 {
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 10px;
    color: #fff !important;
    letter-spacing: -0.02em;
}
#contato-ajuda p {
    opacity: 0.92;
    max-width: 520px;
    margin: 0 auto 36px;
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

<!-- Tabs -->
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
        </ul>
    </div>
</div>

<!-- Tab Content -->
<div class="tab-content" id="ajudaTabContent">

    <!-- ===== ABA AUTORES ===== -->
    <div class="tab-pane fade show active" id="autores" role="tabpanel" aria-labelledby="autores-tab">

        <!-- FAQ Autores -->
        <section class="ajuda-section">
            <div class="container">
                <p class="section-title">Perguntas Frequentes</p>
                <p class="section-subtitle">Respostas às dúvidas mais comuns de autores e leitores.</p>

                <div id="accordionAutores">

                    <div class="faq-card card">
                        <div class="card-header" id="hA0">
                            <button class="collapsed" data-toggle="collapse" data-target="#cA0"
                                    aria-expanded="false" aria-controls="cA0">
                                Como me cadastrar no Portal?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cA0" class="collapse" aria-labelledby="hA0" data-parent="#accordionAutores">
                            <div class="card-body">
                                <p>Clique em <strong>"Acesso"</strong> no menu superior ou acesse diretamente o link de registro:
                                <a href="https://periodicos.ufpb.br/index.php/index/user/register" target="_blank">
                                    periodicos.ufpb.br → Registrar
                                </a>.</p>
                                <p>Preencha as informações básicas: nome, e-mail, instituição e país. Após a confirmação por e-mail, você poderá submeter artigos, acompanhar avaliações e acessar conteúdo restrito.</p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-card card">
                        <div class="card-header" id="hA1">
                            <button class="collapsed" data-toggle="collapse" data-target="#cA1"
                                    aria-expanded="false" aria-controls="cA1">
                                Como submeter um artigo?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cA1" class="collapse" aria-labelledby="hA1" data-parent="#accordionAutores">
                            <div class="card-body">
                                <p>A submissão é feita diretamente no site de cada revista. Acesse <a href="https://periodicos.ufpb.br/capa/index.php" target="_blank">o Portal</a>, pesquise a revista desejada e clique em <strong>"Nova Submissão"</strong>. O processo envolve cinco etapas:</p>
                                <ul>
                                    <li>Início — escolha da seção e confirmação das diretrizes</li>
                                    <li>Metadados — título, autores, resumo, palavras-chave</li>
                                    <li>Upload do arquivo — manuscrito principal e anexos</li>
                                    <li>Confirmação</li>
                                </ul>
                                <p>Consulte as diretrizes específicas de cada revista antes de submeter.</p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-card card">
                        <div class="card-header" id="hA2">
                            <button class="collapsed" data-toggle="collapse" data-target="#cA2"
                                    aria-expanded="false" aria-controls="cA2">
                                Meu artigo foi avaliado?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cA2" class="collapse" aria-labelledby="hA2" data-parent="#accordionAutores">
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

                    <div class="faq-card card">
                        <div class="card-header" id="hA3">
                            <button class="collapsed" data-toggle="collapse" data-target="#cA3"
                                    aria-expanded="false" aria-controls="cA3">
                                Como preencher corretamente os metadados do artigo?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cA3" class="collapse" aria-labelledby="hA3" data-parent="#accordionAutores">
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
                                <div style="margin-top:16px;">
                                    <a href="Manual_Metadados_OJS.pdf" download
                                       style="display:inline-flex; align-items:center; gap:8px; background:#E8682A; color:#fff; border-radius:7px; padding:9px 20px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                        ⬇️ Baixar Manual de Metadados (PDF)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-card card">
                        <div class="card-header" id="hA4">
                            <button class="collapsed" data-toggle="collapse" data-target="#cA4"
                                    aria-expanded="false" aria-controls="cA4">
                                Como acessar o Guia do OJS 3.3?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cA4" class="collapse" aria-labelledby="hA4" data-parent="#accordionAutores">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-9">
                                        <p>O <strong>Guia de Aprendizado do OJS 3.3</strong> é o manual oficial do Public Knowledge Project (PKP), traduzido para o português. Cobre todas as etapas do fluxo editorial: submissão, avaliação, edição, produção e publicação.</p>
                                        <a class="btn btn-sm mt-2" href="https://docs.pkp.sfu.ca/learning-ojs/3.3/pt/" target="_blank"
                                           style="background:#E8682A; color:#fff; border-radius:6px; padding:8px 20px; font-weight:600; text-decoration:none;">
                                            Acessar Guia OJS 3.3
                                        </a>
                                        &nbsp;
                                        <a class="btn btn-sm mt-2" href="https://drive.google.com/file/d/1EsTxRoMKsa7LoZ9aZPmGF2QLOZIyHSy9/view?usp=sharing" target="_blank"
                                           style="background:#3a3a3a; color:#fff; border-radius:6px; padding:8px 20px; font-weight:600; text-decoration:none;">
                                            Manual OJS 3 (IBICT/PDF)
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-card card">
                        <div class="card-header" id="hA5">
                            <button class="collapsed" data-toggle="collapse" data-target="#cA5"
                                    aria-expanded="false" aria-controls="cA5">
                                Como entrar em contato com o Portal?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cA5" class="collapse" aria-labelledby="hA5" data-parent="#accordionAutores">
                            <div class="card-body">
                                <ul>
                                    <li><strong>E-mail:</strong> <a href="mailto:periodicos.ufpb@gmail.com">periodicos.ufpb@gmail.com</a></li>
                                    <li><strong>Telefone / WhatsApp:</strong> <a href="tel:+558332167147">(83) 3216-7147</a></li>
                                    <li><strong>Endereço:</strong> Rua Alameda da Oiticica S/N, Campus I — Prédio da Editora Universitária da UFPB, João Pessoa/PB, CEP 58.051-970</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="faq-card card">
                        <div class="card-header" id="hA6">
                            <button class="collapsed" data-toggle="collapse" data-target="#cA6"
                                    aria-expanded="false" aria-controls="cA6">
                                Qual é a equipe do Portal?
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cA6" class="collapse" aria-labelledby="hA6" data-parent="#accordionAutores">
                            <div class="card-body">
                                <ul>
                                    <li>Ana Roberta Mota — <strong>Bibliotecária</strong></li>
                                    <li>Cassandra Campos — <strong>Editora de Publicações</strong></li>
                                    <li>Fabiana França — <strong>Bibliotecária</strong> (em licença)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div><!-- /accordionAutores -->
            </div>
        </section>

    </div><!-- /tab autores -->


    <!-- ===== ABA EDITORES ===== -->
    <div class="tab-pane fade" id="editores" role="tabpanel" aria-labelledby="editores-tab">

        <!-- Como hospedar -->
        <section class="ajuda-section">
            <div class="container">
                <p class="section-title">Como hospedar minha revista no Portal?</p>
                <p class="section-subtitle">Requisitos e documentação necessária para ingresso.</p>

                <div id="accordionEditores">

                    <div class="faq-card card">
                        <div class="card-header" id="hE0">
                            <button class="collapsed" data-toggle="collapse" data-target="#cE0"
                                    aria-expanded="false" aria-controls="cE0">
                                Documentos necessários para ingresso
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cE0" class="collapse" aria-labelledby="hE0" data-parent="#accordionEditores">
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
                                <p>Envie a documentação para: <a href="mailto:periodicos.ufpb@gmail.com">periodicos.ufpb@gmail.com</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-card card">
                        <div class="card-header" id="hE1">
                            <button class="collapsed" data-toggle="collapse" data-target="#cE1"
                                    aria-expanded="false" aria-controls="cE1">
                                Serviços prestados pelo Portal aos editores
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cE1" class="collapse" aria-labelledby="hE1" data-parent="#accordionEditores">
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

                    <div class="faq-card card">
                        <div class="card-header" id="hE2">
                            <button class="collapsed" data-toggle="collapse" data-target="#cE2"
                                    aria-expanded="false" aria-controls="cE2">
                                Recursos e guias para editores
                                <span class="faq-icon">+</span>
                            </button>
                        </div>
                        <div id="cE2" class="collapse" aria-labelledby="hE2" data-parent="#accordionEditores">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <div class="ic-icon">📘</div>
                                            <h4>Guia OJS 3.3 — Documentação Oficial</h4>
                                            <p>Manual completo do Public Knowledge Project (PKP) em português. Cobre configuração, fluxo editorial, avaliação por pares e publicação.</p>
                                            <a href="https://docs.pkp.sfu.ca/learning-ojs/3.3/pt/" target="_blank"
                                               style="display:inline-block; margin-top:12px; background:#E8682A; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                                Acessar guia
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <div class="ic-icon">📄</div>
                                            <h4>Manual OJS 3 — IBICT</h4>
                                            <p>Adaptação do manual oficial para o contexto das universidades brasileiras, desenvolvido pelo IBICT com foco na língua portuguesa.</p>
                                            <a href="https://drive.google.com/file/d/1EsTxRoMKsa7LoZ9aZPmGF2QLOZIyHSy9/view?usp=sharing" target="_blank"
                                               style="display:inline-block; margin-top:12px; background:#3a3a3a; color:#fff; border-radius:6px; padding:7px 18px; font-size:0.88rem; font-weight:600; text-decoration:none;">
                                                Baixar PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /accordionEditores -->
            </div>
        </section>

        <!-- Manual de Metadados -->
        <section class="ajuda-section gray">
            <div class="container">
                <p class="section-title">Manual de Metadados OJS</p>
                <p class="section-subtitle">Boas práticas para o preenchimento correto dos metadados no sistema.</p>
                <div style="background:#fff; border-radius:14px; padding:28px 32px; margin-bottom:36px; box-shadow:0 4px 18px rgba(0,0,0,0.08); display:flex; align-items:center; gap:28px; flex-wrap:wrap; border-left:5px solid #E8682A;">
                    <div style="font-size:3rem; line-height:1;">📄</div>
                    <div style="flex:1; min-width:200px;">
                        <div style="font-size:1.05rem; font-weight:700; color:#3a3a3a; margin-bottom:4px;">Manual de Preenchimento de Metadados OJS</div>
                        <div style="font-size:0.9rem; color:#666; line-height:1.6;">Guia completo com boas práticas para o preenchimento correto de títulos, autores, afiliações, resumos e palavras-chave no sistema OJS.</div>
                    </div>
                    <a href="Manual_Metadados_OJS.pdf" download
                       style="flex-shrink:0; display:inline-flex; align-items:center; gap:8px; background:#E8682A; color:#fff; border-radius:8px; padding:12px 24px; font-size:0.93rem; font-weight:600; text-decoration:none; white-space:nowrap;">
                        ⬇️ Baixar PDF
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <div class="meta-block">
                            <h5>📌 Regras Gerais</h5>
                            <ul>
                                <li>Nunca use CAPS LOCK em nenhum campo</li>
                                <li>Siga as normas de capitalização da ABNT</li>
                                <li>Não inclua ponto final ao final dos títulos</li>
                                <li>Preencha todos os campos obrigatórios antes de publicar</li>
                            </ul>
                        </div>

                        <div class="meta-block">
                            <h5>📝 Título e Subtítulo</h5>
                            <ul>
                                <li>Apenas a <strong>primeira palavra em maiúscula</strong> (exceto nomes próprios, siglas e topônimos)</li>
                                <li>No OJS, <strong>título e subtítulo possuem campos separados</strong> — preencha cada um no campo correspondente</li>
                                <li>Não use ponto final ao término do título</li>
                            </ul>
                        </div>

                        <div class="meta-block">
                            <h5>👤 Autores</h5>
                            <ul>
                                <li>Nome e sobrenome em <strong>campos separados</strong></li>
                                <li>Não incluir títulos acadêmicos (Dr., Prof., Me. etc.)</li>
                                <li>ORCID no formato completo: <code>https://orcid.org/0000-0000-0000-0000</code></li>
                                <li>Biografias curtas são bem-vindas (até 100 palavras)</li>
                            </ul>
                        </div>

                        <div class="meta-block">
                            <h5>🏛️ Afiliação Institucional</h5>
                            <ul>
                                <li>Informar: departamento, instituição, cidade e país</li>
                                <li><strong>Não use siglas</strong> — escreva por extenso</li>
                                <li>Exemplo: <em>Departamento de Ciência da Informação, Universidade Federal da Paraíba, João Pessoa, Brasil</em></li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="meta-block">
                            <h5>📋 Resumo e Abstract</h5>
                            <ul>
                                <li>Entre <strong>150 e 250 palavras</strong></li>
                                <li>Sem citações bibliográficas</li>
                                <li>Artigos em português exigem <strong>abstract em inglês</strong> obrigatório</li>
                                <li>Estrutura recomendada: objetivo, metodologia, resultados, conclusão</li>
                            </ul>
                        </div>

                        <div class="meta-block">
                            <h5>🔑 Palavras-chave</h5>
                            <ul>
                                <li>Entre <strong>3 e 6 termos</strong></li>
                                <li>Preferencialmente de vocabulário controlado (DeCS, Thesaurus etc.)</li>
                                <li>Cada palavra-chave deve ser confirmada pressionando Enter após digitá-la e o sistema registra cada termo individualmente.</li>
                            </ul>
                        </div>

                        <div class="meta-block" style="border-left-color: #E8682A;">
                            <h5>✅ Checklist antes da publicação</h5>
                            <div class="checklist-item"><span class="check-num">1</span> Título sem CAPS LOCK e sem ponto final</div>
                            <div class="checklist-item"><span class="check-num">2</span> Subtítulo preenchido no campo específico do OJS (campo separado)</div>
                            <div class="checklist-item"><span class="check-num">3</span> Todos os autores cadastrados com nome/sobrenome separados</div>
                            <div class="checklist-item"><span class="check-num">4</span> ORCID no formato URL completo (https://orcid.org/...)</div>
                            <div class="checklist-item"><span class="check-num">5</span> Afiliação por extenso (sem siglas)</div>
                            <div class="checklist-item"><span class="check-num">6</span> Resumo entre 150–250 palavras, sem citações</div>
                            <div class="checklist-item"><span class="check-num">7</span> Abstract em inglês presente (para artigos em PT)</div>
                            <div class="checklist-item"><span class="check-num">8</span> Entre 3 e 6 palavras-chave</div>
                            <div class="checklist-item"><span class="check-num">9</span> DOI atribuído e validado, exceto para DOI atribuído pela Editora UFPB, neste caso, pular esta etapa.</div>
                            <div class="checklist-item"><span class="check-num">10</span> Arquivos finais do artigo (PDF/HTML) enviados e publicados corretamente</div>
                            <div class="checklist-item"><span class="check-num">11</span> Data de publicação definida</div>
                            <div class="checklist-item"><span class="check-num">12</span> Fascículo (número/edição) publicado e visível no site da revista</div>
                        </div>

                    </div>
                </div><!-- /row -->
            </div>
        </section>

    </div><!-- /tab editores -->

</div><!-- /tab-content -->

<!-- Contact -->
<section id="contato-ajuda">
    <div class="container contato-content">
        <h2>Ainda tem dúvidas?</h2>
        <p>Entre em contato com a equipe do Portal de Periódicos da UFPB.</p>
        <div>
            <a class="contact-pill" href="mailto:periodicos.ufpb@gmail.com">
                ✉️ <span><strong>periodicos.ufpb@gmail.com</strong></span>
            </a>
            <a class="contact-pill" href="tel:+558332167147">
                📞 <span><strong>(83) 3216-7147</strong></span>
            </a>
            <span class="contact-pill" style="cursor:default;">
                📍 <span>Editora Universitária da UFPB — Campus I, João Pessoa/PB</span>
            </span>
        </div>
    </div>
</section>

<?php include 'footer.html'; ?>
