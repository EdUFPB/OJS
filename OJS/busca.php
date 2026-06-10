<?php
    include 'header.html';
    require_once 'dados.php';

    $q = isset($_GET['q']) ? trim($_GET['q']) : '';

    $labels = [
        'correntes'     => 'Periódicos Correntes',
        'incubados'     => 'Periódicos Incubados',
        'nao-correntes' => 'Periódicos Não Correntes',
        'anais-eventos' => 'Publicações de Eventos',
    ];

    $cores = [
        'correntes'     => '#E8682A',
        'incubados'     => '#2d6fad',
        'nao-correntes' => '#5a7fa8',
        'anais-eventos' => '#2e8a6a',
    ];

    function normalizar($str) {
        $de   = ['á','à','â','ã','é','è','ê','í','ì','î','ó','ò','ô','õ','ú','ù','û','ü','ç',
                 'Á','À','Â','Ã','É','È','Ê','Í','Ì','Î','Ó','Ò','Ô','Õ','Ú','Ù','Û','Ü','Ç'];
        $para = ['a','a','a','a','e','e','e','i','i','i','o','o','o','o','u','u','u','u','c',
                 'a','a','a','a','e','e','e','i','i','i','o','o','o','o','u','u','u','u','c'];
        return strtolower(str_replace($de, $para, $str));
    }

    $resultados = [];
    $total = 0;

    if ($q !== '') {
        $qN = normalizar($q);
        foreach ($revistas as $r) {
            $bate = stripos(normalizar($r['nome']), $qN) !== false;
            if (!$bate && !empty($r['issn'])) $bate = stripos($r['issn'], $q) !== false;
            if ($bate) {
                $resultados[$r['colecao']][] = $r;
                $total++;
            }
        }
    }
?>

<!-- Hero -->
<section style="background: linear-gradient(135deg, #E8682A 0%, #c4521e 100%); padding: 50px 0 40px; position: relative; overflow: hidden;">
    <div style="position:absolute;top:-60px;right:-60px;width:260px;height:260px;border-radius:50%;background:rgba(255,255,255,0.07);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-80px;left:-40px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,0.05);pointer-events:none;"></div>
    <div class="container" style="position:relative;">
        <h1 style="color:white;font-size:28px;font-weight:800;margin:0 0 6px;">Busca</h1>
        <p style="color:rgba(255,255,255,0.8);font-size:14px;margin:0 0 20px;">Pesquise por título, ISSN ou palavra-chave</p>
        <div style="position:relative;max-width:540px;">
            <span style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#aaa;">🔍</span>
            <input type="text" id="searchInput" value="<?php echo htmlspecialchars($q); ?>"
                placeholder="Buscar periódico por nome, ISSN ou palavra-chave"
                style="width:100%;padding:14px 20px 14px 44px;border-radius:40px;border:none;font-size:14px;box-sizing:border-box;background:#fff;box-shadow:0 2px 12px rgba(0,0,0,0.12);"
                onkeydown="if(event.key==='Enter'){window.location.href='busca.php?q='+encodeURIComponent(this.value)}">
        </div>
    </div>
</section>

<!-- Resultados -->
<section class="wrapper" style="padding-top:0;">
    <div class="container" style="padding-top:2em;padding-bottom:3em;" id="conteudo-principal">

        <?php if ($q !== ''): ?>
            <p style="font-size:14px;color:#808080;margin-bottom:1.5em;">
                <?php if ($total > 0): ?>
                    <strong><?php echo $total; ?></strong> resultado(s) para <strong style="color:#E05A2B;">"<?php echo htmlspecialchars($q); ?>"</strong>
                <?php else: ?>
                    Nenhum resultado para <strong style="color:#444;">"<?php echo htmlspecialchars($q); ?>"</strong>
                <?php endif; ?>
            </p>

            <?php if ($total === 0): ?>
                <div style="text-align:center;padding:4em 0;color:#808080;">
                    <div style="font-size:48px;margin-bottom:0.5em;">🔍</div>
                    <p style="font-size:18px;margin-bottom:0.5em;">Nenhum periódico encontrado.</p>
                    <p>Tente buscar por outro termo ou <a href="periodicos.php" style="color:#E05A2B;">veja todos os periódicos</a>.</p>
                </div>
            <?php else: ?>
                <?php foreach ($labels as $col => $nomeCol): ?>
                    <?php if (!empty($resultados[$col])): ?>
                        <?php $cor = $cores[$col]; ?>
                        <div style="margin-bottom:2.5em;">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:1em;border-bottom:2px solid <?php echo $cor; ?>;padding-bottom:8px;">
                                <h3 style="font-size:17px;font-weight:700;color:#3a3a3a;margin:0;"><?php echo $nomeCol; ?></h3>
                                <span style="background:#f2f4f6;color:#808080;font-size:12px;padding:2px 10px;border-radius:20px;">
                                    <?php echo count($resultados[$col]); ?> resultado(s)
                                </span>
                            </div>
                            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">
                                <?php foreach ($resultados[$col] as $r): ?>
                                    <?php $letra = mb_strtoupper(mb_substr($r['nome'], 0, 1, 'UTF-8')); ?>
                                    <div style="background:#fff;border:1px solid #e8eaed;border-radius:12px;padding:18px 20px;display:flex;flex-direction:column;gap:8px;">
                                        <div style="display:flex;align-items:flex-start;gap:12px;">
                                            <div style="width:42px;height:42px;border-radius:50%;background:<?php echo $cor; ?>;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;flex-shrink:0;">
                                                <?php echo $letra; ?>
                                            </div>
                                            <div>
                                                <div style="font-size:14px;font-weight:600;color:#3a3a3a;line-height:1.3;"><?php echo htmlspecialchars($r['nome']); ?></div>
                                                <?php if (!empty($r['issn'])): ?>
                                                    <div style="font-size:11px;color:#aaa;margin-top:3px;">ISSN <?php echo htmlspecialchars($r['issn']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($r['link'])): ?>
                                            <a href="<?php echo htmlspecialchars($r['link']); ?>" target="_blank"
                                                style="display:inline-block;font-size:12px;color:<?php echo $cor; ?>;text-decoration:none;border:1px solid <?php echo $cor; ?>;padding:5px 14px;border-radius:20px;align-self:flex-start;margin-top:4px;">
                                                Acessar →
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php else: ?>
            <p style="text-align:center;color:#808080;padding:3em;">Digite um termo acima para encontrar periódicos.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.html'; ?>
