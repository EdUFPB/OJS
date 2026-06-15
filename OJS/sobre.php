<?php include 'header.html'; ?>

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
a:focus-visible, button:focus-visible, [tabindex]:focus-visible {
    outline: 3px solid #E8682A;
    outline-offset: 3px;
    border-radius: 4px;
}

/* ── Hero ── */
#sobre-hero {
    background: linear-gradient(135deg, #E8682A 0%, #c4521a 100%);
    padding: 70px 0 60px;
    text-align: center;
    color: #fff !important;
    position: relative;
    overflow: hidden;
}
#sobre-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    pointer-events: none;
}
#sobre-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -40px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}
#sobre-hero .hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.35);
    border-radius: 20px;
    padding: 4px 16px;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #fff !important;
    margin-bottom: 16px;
}
#sobre-hero h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 12px;
    color: #fff !important;
    letter-spacing: -0.02em;
}
#sobre-hero p {
    font-size: 1.05rem;
    opacity: 0.92;
    max-width: 520px;
    margin: 0 auto;
    color: #fff !important;
    line-height: 1.65;
}
#sobre-hero .hero-wave {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    line-height: 0;
}
#sobre-hero .hero-content {
    position: relative;
    z-index: 2;
}
.hero-stats {
    margin-top: 28px;
    display: flex;
    justify-content: center;
    gap: 32px;
    flex-wrap: wrap;
}
.divider {
    width: 1px;
    background: rgba(255,255,255,0.3);
}

/* ── Sections ── */
.sobre-section {
    padding: 52px 0;
    background: #fff;
}
.sobre-section.gray {
    background: #f2f4f6;
}
.sobre-section h2 {
    font-size: 1.45rem;
    font-weight: 700;
    color: #3a3a3a;
    margin-bottom: 6px;
}
.sobre-section .section-divider {
    width: 48px;
    height: 3px;
    background: #E8682A;
    border-radius: 2px;
    margin: 10px 0 24px;
}
.sobre-section p {
    color: #555;
    line-height: 1.8;
    font-size: 0.97rem;
}

/* ── Serviços cards ── */
.servico-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #fff;
    border-radius: 10px;
    padding: 16px 20px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.servico-item .srv-icon {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #fde8d8;
    color: #E8682A;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    margin-top: 1px;
}
.servico-item p {
    margin: 0;
    font-size: 0.93rem;
    color: #444;
    line-height: 1.6;
}

/* ── Indexadores (azul suave) ── */
#indexadores {
    background: #fff;
    padding: 52px 0;
    border-top: 1px solid #eaecf0;
    border-bottom: 1px solid #eaecf0;
}
#indexadores h2 { color: #1B3A6B; font-size: 1.45rem; font-weight: 700; margin-bottom: 6px; }
#indexadores .section-divider { width: 48px; height: 3px; background: #E8682A; border-radius: 2px; margin: 10px 0 24px; }
#indexadores .section-intro { color: #4a6480; max-width: 520px; margin-bottom: 2rem; font-size: 0.95rem; }

.idx-pill {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border: 1.5px solid #c8d8ee;
    border-radius: 50px;
    padding: 10px 20px;
    transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
}
.idx-pill:hover { background: #f0f5ff; border-color: #1B3A6B; box-shadow: 0 2px 10px rgba(27,58,107,0.10); }
.idx-pill .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.idx-pill .sigla { font-size: 13px; font-weight: 700; color: #1B3A6B; letter-spacing: 0.02em; white-space: nowrap; }
.idx-pill .descricao { font-size: 12px; color: #6a82a0; }

/* ── Funcionalidades ── */
#funcionalidades {
    background: #fff3eb;
    padding: 52px 0;
    border-top: 1px solid #f0d5be;
    border-bottom: 1px solid #f0d5be;
}
#funcionalidades h2 { color: #3a3a3a; font-size: 1.3rem; font-weight: 700; margin-bottom: 6px; }
#funcionalidades .section-divider { width: 48px; height: 3px; background: #E8682A; border-radius: 2px; margin: 10px 0 24px; }
.func-card {
    background: #fff;
    border: 1px solid #f0e0d6;
    border-radius: 14px;
    padding: 24px 20px;
    margin-bottom: 12px;
    box-shadow: 0 2px 10px rgba(232,104,42,0.05);
    transition: box-shadow 0.2s, transform 0.2s;
    height: 100%;
}
.func-card:hover { box-shadow: 0 8px 24px rgba(232,104,42,0.12); transform: translateY(-3px); }
.func-card h3 { color: #1B3A6B; font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; }
.func-card p  { color: #666; font-size: 0.88rem; line-height: 1.65; margin: 0; }
.func-card .fi {
    font-size: 1.25rem; margin-bottom: 14px;
    display: inline-flex; width: 44px; height: 44px;
    border-radius: 12px; background: #fde8d8;
    align-items: center; justify-content: center;
}

/* ── Equipe compacta ── */
.equipe-mini {
    display: flex; align-items: center; gap: 14px;
    background: #fff; border-radius: 12px;
    padding: 14px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s;
}
.equipe-mini:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.10); }
.equipe-mini img {
    width: 52px; height: 52px; border-radius: 50%;
    object-fit: cover; object-position: center;
    border: 2px solid #E8682A; filter: grayscale(100%); flex-shrink: 0;
}
.equipe-mini .eq-nome { font-size: 0.9rem; font-weight: 700; color: #222; margin-bottom: 2px; }
.equipe-mini .eq-cargo { font-size: 0.8rem; color: #E8682A; font-weight: 600; margin-bottom: 5px; }
.equipe-mini .eq-obs { font-size: 0.75rem; color: #999; margin-bottom: 5px; }
.equipe-mini a.lattes {
    font-size: 0.75rem; color: #666;
    text-decoration: none; border-bottom: 1px solid #ddd;
    transition: color 0.2s;
}
.equipe-mini a.lattes:hover { color: #E8682A; border-color: #E8682A; }

/* ── Responsive ── */
@media (max-width: 767px) {
    /* Hero */
    #sobre-hero { padding: 44px 0 40px; }
    #sobre-hero h1 { font-size: 1.4rem; }
    #sobre-hero p { font-size: 0.93rem; }
    .hero-stats { gap: 16px; margin-top: 20px; }
    .divider { display: none; }

    /* Sections */
    .sobre-section { padding: 36px 0; }
    #indexadores { padding: 36px 0; }
    #funcionalidades { padding: 36px 0; }

    /* Serviços */
    .servico-item { padding: 12px 14px; gap: 10px; }

    /* Indexadores pills */
    .idx-pill { padding: 8px 14px; }
    .idx-pill .descricao { display: none; }

    /* Funcionalidades */
    .func-card { padding: 18px 16px; }

    /* Equipe compacta */
    .equipe-mini { flex-direction: column; align-items: flex-start; gap: 10px; }
    .equipe-mini img { width: 44px; height: 44px; }
}
</style>

<a class="skip-link" href="#conteudo-sobre">Ir para o conteúdo principal</a>
<main id="conteudo-sobre">

<!-- Hero -->
<section id="sobre-hero" aria-label="Cabeçalho da página Sobre">
    <div class="container hero-content">
        <h1>Sobre o Portal</h1>
        <p>Conheça a história, os serviços e a equipe do Portal de Periódicos da UFPB.</p>
        <div class="hero-stats" role="list" aria-label="Estatísticas do portal">
            <div style="color:#fff;" role="listitem">
                <div style="font-size:1.9rem; font-weight:800; line-height:1;" aria-label="Fundado em 2006">2006</div>
                <div style="font-size:0.78rem; opacity:0.8; margin-top:3px; letter-spacing:0.05em;">Fundação</div>
            </div>
            <div class="divider" aria-hidden="true"></div>
            <div style="color:#fff;" role="listitem">
                <div style="font-size:1.9rem; font-weight:800; line-height:1;" aria-label="Mais de 70 periódicos">+70</div>
                <div style="font-size:0.78rem; opacity:0.8; margin-top:3px; letter-spacing:0.05em;">Periódicos</div>
            </div>
            <div class="divider" aria-hidden="true"></div>
            <div style="color:#fff;" role="listitem">
                <div style="font-size:1.9rem; font-weight:800; line-height:1;" aria-label="Mais de 27 mil artigos publicados">+27mil</div>
                <div style="font-size:0.78rem; opacity:0.8; margin-top:3px; letter-spacing:0.05em;">Artigos publicados</div>
            </div>
        </div>
    </div>
    <div class="hero-wave" aria-hidden="true">
        <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:48px; display:block;">
            <path d="M0,32 C360,0 1080,60 1440,20 L1440,48 L0,48 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<!-- História -->
<section class="sobre-section" aria-label="Nossa História">
    <div class="container">
        <h2>Nossa História</h2>
        <div class="section-divider" aria-hidden="true"></div>
        <div class="row">
            <div class="col-md-8" style="text-align: justify;">
                <p>O <strong>Portal de Periódicos da UFPB</strong> objetiva dar visibilidade à produção científica por meio de revistas eletrônicas científicas elaboradas ou gerenciadas por pesquisadores vinculados à UFPB, possibilitando o acesso e uso de informações científicas e tecnológicas, oferecendo suporte aos editores de periódicos da Instituição, em atenção às determinações da Coordenação de Aperfeiçoamento de Pessoal de Nível Superior (CAPES) e do Conselho Nacional de Desenvolvimento Científico e Tecnológico (CNPq) no que tange a gestão de periódicos científicos.</p>
                <p>O Portal de Periódicos Científicos Eletrônicos da UFPB foi inaugurado em <strong>18 de maio de 2006</strong>, sendo um dos primeiros do gênero em Universidades Federais brasileiras. Foi viabilizado por meio de uma parceria entre a Pró-Reitoria de Pesquisa e Pós-Graduação da UFPB e o Programa de Pós-Graduação em Ciência da Informação da UFPB (PPGCI/UFPB).</p>
                <p>O Portal está vinculado à <strong>Editora da UFPB</strong> e utiliza o Open Journal Systems (OJS), desenvolvido pelo Public Knowledge Project (PKP), que adota as iniciativas de acesso aberto ao conhecimento.</p>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center mt-4 mt-md-0">
                <div style="text-align:center; background:#f2f4f6; border-radius:16px; padding:28px 32px;">
                    <div style="font-size:0.8rem; font-weight:600; color:#E8682A; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Acesso aberto</div>
                    <div style="font-size:0.93rem; color:#555; line-height:1.65;">Todos os artigos publicados no Portal são de acesso aberto, sem custos para leitores ou autores.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Serviços -->
<section class="sobre-section gray" aria-label="Serviços Oferecidos">
    <div class="container">
        <h2>Serviços Oferecidos</h2>
        <div class="section-divider" aria-hidden="true"></div>
        <p style="margin-bottom:28px;">O Portal de Periódicos da UFPB orienta e presta auxílio aos editores nos seguintes serviços:</p>
        <div class="row">
            <div class="col-md-6">
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">📋</div>
                    <p>Orientação aos editores quanto ao <strong>credenciamento no Portal</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">🔍</div>
                    <p>Auxílio e orientação quanto à <strong>indexação em bases de dados</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">📁</div>
                    <p>Suporte na <strong>inserção de números retrospectivos</strong> no OJS</p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">🎓</div>
                    <p><strong>Capacitação e treinamentos</strong> na plataforma Open Journal Systems (OJS)</p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">⚖️</div>
                    <p>Orientação sobre <strong>ética, boas práticas e normas editoriais</strong></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">💰</div>
                    <p>Orientação sobre <strong>fontes e editais de financiamento</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">🔗</div>
                    <p>Orientação e validação do <strong>Digital Object Identifier (DOI)</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">🆔</div>
                    <p>Orientação para abertura e uso do <strong>ORCID</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">📰</div>
                    <p>Auxílio na obtenção do <strong>ISSN</strong> junto ao IBICT</p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon" aria-hidden="true">🌱</div>
                    <p><strong>Incubação de periódicos emergentes</strong> e inclusão na rede CARINIANA</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Indexadores -->
<section id="indexadores" aria-label="Indexadores e Bases de Dados">
    <div class="container">
        <h2>Indexadores e Bases de Dados</h2>
        <div class="section-divider" aria-hidden="true"></div>
        <p class="section-intro">Os periódicos do Portal estão indexados nas principais bases científicas nacionais e internacionais, garantindo visibilidade e impacto às publicações.</p>
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
        <div style="display: flex; flex-wrap: wrap; gap: 12px;" role="list" aria-label="Lista de indexadores">
            <?php foreach ($indexadores as $idx): ?>
            <div class="idx-pill" role="listitem">
                <span class="dot" style="background: <?= $idx['cor'] ?>;" aria-hidden="true"></span>
                <span class="sigla"><?= $idx['sigla'] ?></span>
                <span class="descricao"><?= $idx['nome'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Funcionalidades -->
<section id="funcionalidades" aria-label="Funcionalidades do Portal">
    <div class="container">
        <h2>Funcionalidades do Portal</h2>
        <div class="section-divider" aria-hidden="true"></div>
        <div class="row mt-3">
            <div class="col-md-6 col-lg-4 mb-4 d-flex">
                <div class="func-card">
                    <span class="fi" aria-hidden="true">📝</span>
                    <h3>Submissão Online</h3>
                    <p>Autores submetem artigos diretamente pelo OJS, com acompanhamento em tempo real de cada etapa do processo editorial.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 d-flex">
                <div class="func-card">
                    <span class="fi" aria-hidden="true">🔒</span>
                    <h3>Avaliação por Pares</h3>
                    <p>Revisão duplo-cega ou aberta conforme política de cada periódico, com anonimato e rastreabilidade garantidos.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 d-flex">
                <div class="func-card">
                    <span class="fi" aria-hidden="true">🌐</span>
                    <h3>Acesso Aberto</h3>
                    <p>Todos os artigos publicados são disponibilizados em acesso aberto, sem barreiras de pagamento para leitores ou autores.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 d-flex">
                <div class="func-card">
                    <span class="fi" aria-hidden="true">🔗</span>
                    <h3>DOI e ORCID</h3>
                    <p>Registramos DOI para cada artigo via CrossRef e orientamos autores na utilização do identificador ORCID.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 d-flex">
                <div class="func-card">
                    <span class="fi" aria-hidden="true">📊</span>
                    <h3>Estatísticas de Uso</h3>
                    <p>Dados de acesso, download e citação disponibilizados publicamente para cada periódico e artigo do portal.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 d-flex">
                <div class="func-card">
                    <span class="fi" aria-hidden="true">🛡️</span>
                    <h3>Preservação Digital</h3>
                    <p>Integrados à rede CARINIANA do IBICT, garantindo a preservação de longo prazo do acervo científico publicado.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipe -->
<section class="sobre-section" aria-label="Nossa Equipe" style="padding: 40px 0;">
    <div class="container">
        <h2>Nossa Equipe</h2>
        <div class="section-divider" aria-hidden="true"></div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="equipe-mini">
                    <img src="images/ana.png" alt="Foto de Ana Roberta Mota">
                    <div>
                        <div class="eq-nome">Ana Roberta Mota</div>
                        <div class="eq-cargo">Bibliotecária</div>
                        <a class="lattes" href="http://lattes.cnpq.br/6636072425703164" target="_blank" rel="noopener noreferrer">Currículo Lattes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="equipe-mini">
                    <img src="images/cassandra.jpg" alt="Foto de Cassandra Campos">
                    <div>
                        <div class="eq-nome">Cassandra Campos</div>
                        <div class="eq-cargo">Editora de Publicações</div>
                        <a class="lattes" href="http://lattes.cnpq.br/8767155212928230" target="_blank" rel="noopener noreferrer">Currículo Lattes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="equipe-mini">
                    <img src="images/fabi.png" alt="Foto de Fabiana França">
                    <div>
                        <div class="eq-nome">Fabiana França</div>
                        <div class="eq-cargo">Bibliotecária</div>
                        <a class="lattes" href="http://lattes.cnpq.br/0843349256910839" target="_blank" rel="noopener noreferrer">Currículo Lattes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<?php include 'footer.html'; ?>
