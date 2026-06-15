<?php
    include 'header.html';
    require_once 'dados.php';
    require_once 'noticias.php';
    $revistas_json = json_encode($revistas, JSON_UNESCAPED_UNICODE);
?>

<style>
/* ===== SKIP LINK ===== */
.skip-link {
    position: absolute; top: -40px; left: 0;
    background: #E8682A; color: #fff;
    padding: 8px 16px; font-size: 14px; font-weight: 600;
    z-index: 10000; text-decoration: none;
    border-radius: 0 0 8px 0; transition: top 0.2s;
}
.skip-link:focus { top: 0; }

/* ===== FOCUS VISÍVEL ===== */
a:focus-visible, button:focus-visible, input:focus-visible, [tabindex]:focus-visible {
    outline: 3px solid #E8682A;
    outline-offset: 3px;
    border-radius: 4px;
}

/* ===== HERO ===== */
#hero {
    background: linear-gradient(135deg, #E8682A 0%, #c4521e 100%);
    padding: 70px 0 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
#hero::before {
    content:''; position:absolute; top:-80px; right:-80px;
    width:340px; height:340px; border-radius:50%;
    background:rgba(255,255,255,0.07); pointer-events:none;
}
#hero::after {
    content:''; position:absolute; bottom:-100px; left:-60px;
    width:280px; height:280px; border-radius:50%;
    background:rgba(255,255,255,0.05); pointer-events:none;
}
#hero .hero-inner { position:relative; z-index:2; }

/* ===== AUTOCOMPLETE ===== */
.search-container { position: relative; max-width: 500px; margin: 0 auto; }
.autocomplete-list {
    display: none; position: absolute;
    top: calc(100% + 6px); left: 0; right: 0;
    background: #fff; border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    z-index: 9999; overflow: hidden; text-align: left;
    max-height: 280px; overflow-y: auto;
}
.autocomplete-item {
    padding: 10px 16px; cursor: pointer;
    border-bottom: 1px solid #f5f5f5;
    display: flex; justify-content: space-between;
    align-items: center; gap: 8px;
    font-size: 14px; color: #333;
}
.autocomplete-item:last-child { border-bottom: none; }
.autocomplete-item:hover, .autocomplete-item.ativo { background: #fff5f0; }
.autocomplete-item .tag {
    font-size: 11px; padding: 2px 8px; border-radius: 10px;
    background: #fde8d8; color: #993c1d;
    white-space: nowrap; flex-shrink: 0;
}
.autocomplete-vazia { padding: 12px 16px; font-size: 13px; color: #999; }

/* ===== SOBRE — DUAS COLUNAS ===== */
.sobre-two-col { display: flex; align-items: center; gap: 60px; flex-wrap: wrap; }
.sobre-two-col .sobre-text { flex: 1; min-width: 280px; }
.sobre-two-col .sobre-stats-card { flex: 0 0 auto; min-width: 240px; }

/* ===== MOBILE ===== */
@media (max-width: 767px) {
    #hero h1 { font-size: 22px !important; }
    #hero p  { font-size: 13px !important; }
    #hero .search-box { padding: 10px 16px 10px 36px !important; font-size: 13px !important; }

    .sobre-two-col { flex-direction: column; gap: 32px; }
    .sobre-two-col .sobre-stats-card { min-width: 100%; width: 100%; }

    .equipe-mobile { flex-direction: column !important; align-items: stretch !important; }
    .equipe-mobile > div { min-width: 100% !important; }

    .indexadores-pills > div { width: calc(50% - 6px); }

    #four .container > div { flex-direction: column !important; }

    #colecoes .col-lg-3 { margin-bottom: 16px; }
}
</style>

<a class="skip-link" href="#conteudo-principal">Ir para o conteúdo principal</a>
<main id="conteudo-principal">

<!-- Hero Banner -->
<section id="hero" aria-label="Busca de periódicos">
    <div class="container hero-inner">
        <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin: 0 0 0.4em; font-family: 'Inter', Helvetica, sans-serif; letter-spacing: -0.02em;">
            Explore os periódicos científicos da UFPB
        </h1>
        <p style="color: rgba(255,255,255,0.88); font-size: 14px; max-width: 520px; margin: 0 auto 1.5em; line-height: 1.7;">
            Pesquise por título, área ou ISSN — encontre periódicos relevantes rapidamente e acesse produções de alta qualidade técnica e científica.
        </p>
        <div class="search-container">
            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999; pointer-events:none;" aria-hidden="true">🔍</span>
            <form id="formBusca" method="GET" action="busca.php" autocomplete="off" style="margin:0;" role="search">
                <input type="text" id="campoBusca" name="q"
                    placeholder="Buscar periódico por nome, ISSN ou palavra-chave"
                    class="search-box"
                    style="width: 100%; padding: 13px 20px 13px 40px; border-radius: 40px; border: none; font-size: 14px; box-sizing: border-box; background: #f2f4f6; outline: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);"
                    aria-label="Buscar periódico"
                    aria-autocomplete="list"
                    aria-controls="autocompleteList">
            </form>
            <div class="autocomplete-list" id="autocompleteList" role="listbox" aria-label="Sugestões de periódicos"></div>
        </div>
        <div style="margin-top: 1.2em;">
            <span style="background: rgba(255,255,255,0.18); color: white; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">✦ Open Access</span>
        </div>
    </div>
</section>

<!-- Nossas Coleções -->
<section id="colecoes" aria-label="Nossas Coleções" style="background: #fff; padding: 64px 0 56px;">
    <div class="container">
        <div class="text-center mb-5">
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; color: #E8682A; font-weight: 600; margin-bottom: 0.4rem;">Acervo científico</p>
            <h2 style="font-size: 28px; font-weight: 800; color: #1B3A6B; margin-bottom: 0.5rem;">Nossas Coleções</h2>
            <p style="font-size: 14px; color: #888; max-width: 460px; margin: 0 auto; line-height: 1.7;">Navegue pelos nossos catálogos organizados por status e maturidade editorial.</p>
        </div>
        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-3 mb-4 d-flex">
                <a href="periodicos.php" style="text-decoration: none; display: flex; width: 100%;" aria-label="Ver coleção Correntes">
                    <div style="background: linear-gradient(145deg, #fff5f1, #fff); border: 1.5px solid #f5c4ae; border-radius: 18px; padding: 32px 24px 28px; text-align: center; width: 100%; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 12px rgba(232,104,42,0.06);" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 12px 32px rgba(232,104,42,0.15)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(232,104,42,0.06)'">
                        <div style="width: 56px; height: 56px; border-radius: 16px; background: #E8682A; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 6px 16px rgba(232,104,42,0.35);" aria-hidden="true">📚</div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #1B3A6B; margin-bottom: 10px;">Correntes</h3>
                        <p style="font-size: 13px; color: #666; line-height: 1.65; margin-bottom: 20px;">Periódicos em plena atividade editorial, com publicações regulares e avaliação por pares.</p>
                        <span style="font-size: 13px; font-weight: 700; color: #E8682A;">Ver coleção →</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3 mb-4 d-flex">
                <a href="incubadas.php" style="text-decoration: none; display: flex; width: 100%;" aria-label="Ver coleção Incubados">
                    <div style="background: linear-gradient(145deg, #eef2f9, #fff); border: 1.5px solid #b8cae3; border-radius: 18px; padding: 32px 24px 28px; text-align: center; width: 100%; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 12px rgba(27,58,107,0.06);" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 12px 32px rgba(27,58,107,0.15)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(27,58,107,0.06)'">
                        <div style="width: 56px; height: 56px; border-radius: 16px; background: #1B3A6B; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 6px 16px rgba(27,58,107,0.35);" aria-hidden="true">🌱</div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #1B3A6B; margin-bottom: 10px;">Incubados</h3>
                        <p style="font-size: 13px; color: #666; line-height: 1.65; margin-bottom: 20px;">Novos projetos editoriais em fase de estruturação e crescimento dentro do portal.</p>
                        <span style="font-size: 13px; font-weight: 700; color: #1B3A6B;">Ver coleção →</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3 mb-4 d-flex">
                <a href="nao-correntes.php" style="text-decoration: none; display: flex; width: 100%;" aria-label="Ver coleção Não Correntes">
                    <div style="background: linear-gradient(145deg, #f5f5f5, #fff); border: 1.5px solid #d8d8d8; border-radius: 18px; padding: 32px 24px 28px; text-align: center; width: 100%; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 12px rgba(0,0,0,0.05);" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.10)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.05)'">
                        <div style="width: 56px; height: 56px; border-radius: 16px; background: #6b7280; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 6px 16px rgba(107,114,128,0.35);" aria-hidden="true">🗄️</div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #1B3A6B; margin-bottom: 10px;">Não Correntes</h3>
                        <p style="font-size: 13px; color: #666; line-height: 1.65; margin-bottom: 20px;">Periódicos que encerraram atividades, preservados como fonte essencial de consulta.</p>
                        <span style="font-size: 13px; font-weight: 700; color: #6b7280;">Ver coleção →</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3 mb-4 d-flex">
                <a href="anais-eventos.php" style="text-decoration: none; display: flex; width: 100%;" aria-label="Ver coleção Publicações de Eventos">
                    <div style="background: linear-gradient(145deg, #edf7f4, #fff); border: 1.5px solid #a5d8cc; border-radius: 18px; padding: 32px 24px 28px; text-align: center; width: 100%; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 12px rgba(46,138,106,0.06);" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 12px 32px rgba(46,138,106,0.15)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(46,138,106,0.06)'">
                        <div style="width: 56px; height: 56px; border-radius: 16px; background: #2e8a6a; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 6px 16px rgba(46,138,106,0.35);" aria-hidden="true">🎓</div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #1B3A6B; margin-bottom: 10px;">Publicações de Eventos</h3>
                        <p style="font-size: 13px; color: #666; line-height: 1.65; margin-bottom: 20px;">Anais e revistas vinculados a congressos, colóquios e encontros científicos da UFPB.</p>
                        <span style="font-size: 13px; font-weight: 700; color: #2e8a6a;">Ver coleção →</span>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Notícias -->
<section aria-label="Notícias e Anúncios" style="background: #f2f4f6; padding: 64px 0 52px; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; line-height: 0;" aria-hidden="true">
        <svg viewBox="0 0 1440 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:40px; display:block;">
            <path d="M0,20 C480,50 960,0 1440,20 L1440,0 L0,0 Z" fill="#ffffff"/>
        </svg>
    </div>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2em; flex-wrap: wrap; gap: 8px;">
            <div>
                <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; color: #E8682A; font-weight: 600; margin-bottom: 0.3rem;">Fique por dentro</p>
                <h2 style="font-size: 22px; color: #1B3A6B; font-weight: 700; margin: 0;">Notícias e Anúncios</h2>
            </div>
            <a href="noticias-todas.php" style="font-size: 13px; color: #E8682A; text-decoration: none; font-weight: 600;">Ver todas →</a>
        </div>
        <div class="row">
            <?php
            $cores_categoria = [
                'Institucional' => '#1B3A6B',
                'Editorial'     => '#2e8a6a',
                'Chamada'       => '#E8682A',
            ];
            $recentes = array_slice($noticias, 0, 3);
            foreach ($recentes as $n):
                $cor = $cores_categoria[$n['categoria']] ?? '#888';
                $data_fmt = date('d/m/Y', strtotime($n['data']));
            ?>
            <div class="col-md-4 mb-4">
                <a href="<?= htmlspecialchars($n['link']) ?>" style="text-decoration: none; color: inherit; display: block; height: 100%;">
                    <article style="background: #fff; border-radius: 12px; padding: 24px; height: 100%; border-top: 3px solid <?= $cor ?>; transition: box-shadow 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.05);" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,0,0,0.10)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="background: <?= $cor ?>22; color: <?= $cor ?>; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em;"><?= htmlspecialchars($n['categoria']) ?></span>
                            <time datetime="<?= $n['data'] ?>" style="font-size: 12px; color: #aaa;"><?= $data_fmt ?></time>
                        </div>
                        <h3 style="font-size: 15px; font-weight: 700; color: #222; margin-bottom: 10px; line-height: 1.45;"><?= htmlspecialchars($n['titulo']) ?></h3>
                        <p style="font-size: 13px; color: #666; line-height: 1.7; margin: 0;"><?= htmlspecialchars($n['resumo']) ?></p>
                    </article>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Sobre -->
<section id="three" aria-label="Sobre o Portal" style="background: #fff; padding: 64px 0 72px; position: relative;">
    <div class="container">
        <div class="sobre-two-col">

            <div class="sobre-text">
                <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; color: #E8682A; font-weight: 600; margin-bottom: 0.5rem;">Sobre o portal</p>
                <h2 style="font-size: 26px; color: #1B3A6B; font-weight: 800; margin-bottom: 1.1rem; line-height: 1.3;">Ciência aberta da Paraíba para o mundo</h2>
                <p style="font-size: 14px; line-height: 1.85; color: #4a5e7a; margin-bottom: 1.5em;">
                    O Portal de Periódicos da UFPB é um espaço estratégico para a comunicação científica da Universidade Federal da Paraíba, promovendo acesso aberto, visibilidade internacional e suporte editorial a pesquisadores e editores.
                </p>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1.8em;">
                    <span style="background: #fde8d8; color: #E8682A; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">✦ Open Access</span>
                    <span style="background: #e0e8f5; color: #1B3A6B; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">📅 Desde 2006</span>
                    <span style="background: #e6f4f1; color: #2a7a6e; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">🌐 OJS</span>
                </div>
                <a href="sobre.php" style="background: #E8682A; color: white; padding: 12px 28px; font-size: 14px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">Conheça o Portal →</a>
            </div>

            <div class="sobre-stats-card">
                <div style="background: linear-gradient(135deg, #1B3A6B 0%, #2c4a7c 100%); border-radius: 20px; padding: 36px 40px; text-align: center; box-shadow: 0 12px 40px rgba(27,58,107,0.18);" role="list" aria-label="Estatísticas do portal">
                    <div style="margin-bottom: 28px;" role="listitem">
                        <div style="font-size: 48px; font-weight: 900; color: #fff; line-height: 1;" aria-label="Mais de 70 periódicos">+70</div>
                        <div style="font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1.5px; margin-top: 4px;">Periódicos</div>
                    </div>
                    <div style="height: 1px; background: rgba(255,255,255,0.12); margin-bottom: 28px;" aria-hidden="true"></div>
                    <div style="margin-bottom: 28px;" role="listitem">
                        <div style="font-size: 48px; font-weight: 900; color: #fff; line-height: 1;" aria-label="Mais de 27 mil artigos publicados">+27mil</div>
                        <div style="font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1.5px; margin-top: 4px;">Artigos publicados</div>
                    </div>
                    <div style="height: 1px; background: rgba(255,255,255,0.12); margin-bottom: 28px;" aria-hidden="true"></div>
                    <div role="listitem">
                        <div style="font-size: 48px; font-weight: 900; color: #E8682A; line-height: 1;" aria-label="Fundado em 2006">2006</div>
                        <div style="font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1.5px; margin-top: 4px;">Ano de fundação</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div style="position: absolute; bottom: 0; left: 0; right: 0; line-height: 0;" aria-hidden="true">
        <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:48px; display:block;">
            <path d="M0,24 C480,56 960,0 1440,32 L1440,48 L0,48 Z" fill="#2c4a7c"/>
        </svg>
    </div>
</section>

<!-- Indexadores -->
<section aria-label="Indexadores e Bases de Dados" style="background: #2c4a7c; padding: 52px 0 60px; position: relative; overflow: hidden;">
    <div class="container">
        <div class="text-center mb-4">
            <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; color: #E8682A; font-weight: 600; margin-bottom: 0.4rem;">Visibilidade Internacional</p>
            <h2 style="font-size: 22px; color: #fff; font-weight: 700; margin-bottom: 0.5rem;">Indexadores e Bases de Dados</h2>
            <p style="color: rgba(255,255,255,0.6); max-width: 480px; margin: 0 auto; font-size: 13px; line-height: 1.7;">
                Indexados nas principais bases científicas nacionais e internacionais.
            </p>
        </div>
        <?php
        $indexadores = [
            ['sigla' => 'DOAJ',     'nome' => 'Directory of Open Access Journals', 'cor' => '#e63946'],
            ['sigla' => 'Latindex', 'nome' => 'Sistema Regional de Información',   'cor' => '#60a5c8'],
            ['sigla' => 'SciELO',   'nome' => 'Scientific Electronic Library',     'cor' => '#2dd4bf'],
            ['sigla' => 'CrossRef', 'nome' => 'Crossref / DOI',                    'cor' => '#fb923c'],
            ['sigla' => 'PubMed',   'nome' => 'PubMed / MEDLINE',                  'cor' => '#60a5fa'],
            ['sigla' => 'DataCite', 'nome' => 'DataCite',                           'cor' => '#c084fc'],
            ['sigla' => 'Google',   'nome' => 'Google Acadêmico',                  'cor' => '#86efac'],
        ];
        ?>
        <div class="indexadores-pills" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 32px;" role="list" aria-label="Lista de indexadores">
            <?php foreach ($indexadores as $idx): ?>
            <div role="listitem" style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.14); border-radius: 50px; padding: 10px 20px; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.16)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: <?= $idx['cor'] ?>; flex-shrink: 0; display: inline-block;" aria-hidden="true"></span>
                <span style="font-size: 13px; font-weight: 700; color: #fff; letter-spacing: 0.02em;"><?= $idx['sigla'] ?></span>
                <span style="font-size: 12px; color: rgba(255,255,255,0.55);"><?= $idx['nome'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- OJS -->
<section id="four" aria-label="Plataforma OJS" style="background-color: #f2f4f6; padding: 4em 2em;">
    <div class="container">
        <div style="display: flex; align-items: center; gap: 3em; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 280px;">
                <span style="background: #fde8d8; color: #E8682A; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">🖥 Infraestrutura de Ponta</span>
                <h2 style="color: #1B3A6B; font-size: 26px; margin-top: 0.8em; line-height: 1.3;"><strong>Baseado no ecossistema Open Journal Systems (OJS)</strong></h2>
                <p style="color: #3d5070; font-size: 14px; line-height: 1.8; max-width: 450px;">Utilizamos o padrão ouro global para publicação científica de código aberto. Uma interface intuitiva para submissões, avaliação por pares e publicação rápida.</p>
                <div style="margin-top: 1.5em;">
                    <a href="acesso.php" style="background: #E8682A; color: white; padding: 12px 24px; border-radius: 8px; font-size: 14px; text-decoration: none; font-weight: bold;">Acesse a plataforma</a>
                </div>
            </div>
            <div style="flex: 1; min-width: 280px;">
                <div style="background: white; border-radius: 12px; padding: 1.5em; box-shadow: 0 8px 24px rgba(0,0,0,0.1);">
                    <img src="images/ojs.png" alt="Interface do sistema OJS utilizado pelo portal" style="width: 100%; border-radius: 8px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipe -->
<section aria-label="Equipe do Portal" style="background: #fff; padding: 36px 0 40px; text-align: center; border-top: 2px solid #f0f0f0;">
    <div class="container">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; color: #E8682A; font-weight: 600; margin-bottom: 0.3rem;">Equipe</p>
        <h2 style="font-size: 17px; font-weight: 700; color: #1B3A6B; margin-bottom: 1.8rem;">Quem faz o Portal acontecer</h2>
        <div class="equipe-mobile" style="display: flex; justify-content: center; gap: 24px; flex-wrap: wrap;">

            <div style="display: flex; align-items: center; gap: 12px; background: #f8f8f6; border-radius: 12px; padding: 14px 20px; min-width: 220px; max-width: 280px;">
                <img src="images/ana.png" alt="Foto de Ana Roberta Mota" width="48" height="48" style="border-radius: 50%; object-fit: cover; object-position: center; filter: grayscale(100%); border: 2px solid #E8682A; flex-shrink:0;" />
                <div style="text-align: left;">
                    <div style="font-size: 13px; font-weight: 700; color: #222;">Ana Roberta Mota</div>
                    <div style="font-size: 12px; color: #E8682A; margin-bottom: 3px;">Bibliotecária</div>
                    <a href="http://lattes.cnpq.br/6636072425703164" target="_blank" rel="noopener noreferrer" style="font-size: 11px; color: #999; text-decoration: none; border-bottom: 0.5px solid #ccc;">Currículo Lattes</a>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 12px; background: #f8f8f6; border-radius: 12px; padding: 14px 20px; min-width: 220px; max-width: 280px;">
                <img src="images/cassandra.jpg" alt="Foto de Cassandra Campos" width="48" height="48" style="border-radius: 50%; object-fit: cover; filter: grayscale(100%); border: 2px solid #E8682A; flex-shrink:0;" />
                <div style="text-align: left;">
                    <div style="font-size: 13px; font-weight: 700; color: #222;">Cassandra Campos</div>
                    <div style="font-size: 12px; color: #E8682A; margin-bottom: 3px;">Editora de Publicações</div>
                    <a href="http://lattes.cnpq.br/8767155212928230" target="_blank" rel="noopener noreferrer" style="font-size: 11px; color: #999; text-decoration: none; border-bottom: 0.5px solid #ccc;">Currículo Lattes</a>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 12px; background: #f8f8f6; border-radius: 12px; padding: 14px 20px; min-width: 220px; max-width: 280px;">
                <img src="images/fabi.png" alt="Foto de Fabiana França" width="48" height="48" style="border-radius: 50%; object-fit: cover; filter: grayscale(100%); border: 2px solid #E8682A; flex-shrink:0;" />
                <div style="text-align: left;">
                    <div style="font-size: 13px; font-weight: 700; color: #222;">Fabiana França</div>
                    <div style="font-size: 12px; color: #E8682A; margin-bottom: 3px;">Bibliotecária</div>
                    <a href="http://lattes.cnpq.br/0843349256910839" target="_blank" rel="noopener noreferrer" style="font-size: 11px; color: #999; text-decoration: none; border-bottom: 0.5px solid #ccc;">Currículo Lattes</a>
                </div>
            </div>

        </div>
    </div>
</section>

</main>

<!-- Script de Autocomplete -->
<script>
var revistas = <?php echo $revistas_json; ?>;
var labels = { correntes: 'Corrente', incubados: 'Incubado', 'nao-correntes': 'Não Corrente', 'anais-eventos': 'Pub. Eventos' };

function removerAcentos(str) {
    return str.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
}

var campo = document.getElementById('campoBusca');
var lista  = document.getElementById('autocompleteList');
var ativo  = -1;

campo.addEventListener('input', function() {
    var termo = removerAcentos(this.value.trim());
    lista.innerHTML = '';
    ativo = -1;
    if (termo.length < 2) { lista.style.display = 'none'; return; }

    var encontrados = revistas.filter(function(r) {
        return removerAcentos(r.nome).indexOf(termo) !== -1;
    }).slice(0, 8);

    if (encontrados.length === 0) {
        lista.innerHTML = '<div class="autocomplete-vazia">Nenhum periódico encontrado.</div>';
    } else {
        encontrados.forEach(function(r, idx) {
            var item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.setAttribute('role', 'option');
            item.setAttribute('id', 'ac-item-' + idx);
            item.innerHTML = '<span>' + r.nome + '</span><span class="tag">' + (labels[r.colecao] || r.colecao) + '</span>';
            item.addEventListener('mousedown', function(e) {
                e.preventDefault();
                if (r.link) { window.open(r.link, '_blank'); }
                else { campo.value = r.nome; document.getElementById('formBusca').submit(); }
                lista.style.display = 'none';
            });
            lista.appendChild(item);
        });
    }
    lista.style.display = 'block';
});

campo.addEventListener('keydown', function(e) {
    var itens = lista.querySelectorAll('.autocomplete-item');
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        ativo = Math.min(ativo + 1, itens.length - 1);
        itens.forEach(function(el, i) { el.classList.toggle('ativo', i === ativo); });
        if (itens[ativo]) campo.setAttribute('aria-activedescendant', 'ac-item-' + ativo);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        ativo = Math.max(ativo - 1, -1);
        itens.forEach(function(el, i) { el.classList.toggle('ativo', i === ativo); });
    } else if (e.key === 'Enter' && ativo >= 0) {
        e.preventDefault();
        if (itens[ativo]) itens[ativo].dispatchEvent(new MouseEvent('mousedown'));
    } else if (e.key === 'Escape') {
        lista.style.display = 'none';
        campo.removeAttribute('aria-activedescendant');
    }
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-container')) lista.style.display = 'none';
});
</script>

<?php include 'footer.html'; ?>
