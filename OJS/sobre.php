<?php include 'header.html'; ?>

<style>
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

/* ── Sections ── */
.sobre-section {
    padding: 56px 0;
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

/* ── Equipe cards ── */
.equipe-card {
    background: #fff;
    border-radius: 14px;
    padding: 32px 20px 24px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
}
.equipe-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.equipe-card img {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
    border: 3px solid #E8682A;
    filter: grayscale(100%);
    margin-bottom: 16px;
}
.equipe-card .eq-nome {
    font-size: 1rem;
    font-weight: 700;
    color: #3a3a3a;
    margin-bottom: 4px;
}
.equipe-card .eq-cargo {
    font-size: 0.88rem;
    color: #E8682A;
    font-weight: 600;
    margin-bottom: 14px;
}
.equipe-card .eq-obs {
    font-size: 0.82rem;
    color: #999;
    margin-bottom: 14px;
}
.equipe-card a.lattes {
    display: inline-block;
    font-size: 0.82rem;
    color: #fff;
    background: #3a3a3a;
    border-radius: 20px;
    padding: 5px 16px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s;
}
.equipe-card a.lattes:hover {
    background: #E8682A;
    text-decoration: none;
}

/* ── Responsive ── */
@media (max-width: 767px) {
    #sobre-hero h1 { font-size: 1.4rem; }
    .sobre-section { padding: 40px 0; }
}
</style>

<!-- Hero -->
<section id="sobre-hero">
    <div class="container hero-content">
        <h1>Sobre o Portal</h1>
        <p>Conheça a história, os serviços e a equipe do Portal de Periódicos da UFPB.</p>
        <div style="margin-top:28px; display:flex; justify-content:center; gap:32px; flex-wrap:wrap;">
            <div style="color:#fff;">
                <div style="font-size:1.9rem; font-weight:800; line-height:1;">2006</div>
                <div style="font-size:0.78rem; opacity:0.8; margin-top:3px; letter-spacing:0.05em;">Fundação</div>
            </div>
            <div style="width:1px; background:rgba(255,255,255,0.3);"></div>
            <div style="color:#fff;">
                <div style="font-size:1.9rem; font-weight:800; line-height:1;">+70</div>
                <div style="font-size:0.78rem; opacity:0.8; margin-top:3px; letter-spacing:0.05em;">Periódicos</div>
            </div>
            <div style="width:1px; background:rgba(255,255,255,0.3);"></div>
            <div style="color:#fff;">
                <div style="font-size:1.9rem; font-weight:800; line-height:1;">+27mil</div>
                <div style="font-size:0.78rem; opacity:0.8; margin-top:3px; letter-spacing:0.05em;">Artigos publicados</div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%; height:48px; display:block;">
            <path d="M0,32 C360,0 1080,60 1440,20 L1440,48 L0,48 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<!-- História -->
<section class="sobre-section">
    <div class="container">
        <h2>Nossa História</h2>
        <div class="section-divider"></div>
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
<section class="sobre-section gray">
    <div class="container">
        <h2>Serviços Oferecidos</h2>
        <div class="section-divider"></div>
        <p style="margin-bottom:28px;">O Portal de Periódicos da UFPB orienta e presta auxílio aos editores nos seguintes serviços:</p>
        <div class="row">
            <div class="col-md-6">
                <div class="servico-item">
                    <div class="srv-icon">📋</div>
                    <p>Orientação aos editores quanto ao <strong>credenciamento no Portal</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">🔍</div>
                    <p>Auxílio e orientação quanto à <strong>indexação em bases de dados</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">📁</div>
                    <p>Suporte na <strong>inserção de números retrospectivos</strong> no OJS</p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">🎓</div>
                    <p><strong>Capacitação e treinamentos</strong> na plataforma Open Journal Systems (OJS)</p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">⚖️</div>
                    <p>Orientação sobre <strong>ética, boas práticas e normas editoriais</strong></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="servico-item">
                    <div class="srv-icon">💰</div>
                    <p>Orientação sobre <strong>fontes e editais de financiamento</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">🔗</div>
                    <p>Orientação e validação do <strong>Digital Object Identifier (DOI)</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">🆔</div>
                    <p>Orientação para abertura e uso do <strong>ORCID</strong></p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">📰</div>
                    <p>Auxílio na obtenção do <strong>ISSN</strong> junto ao IBICT</p>
                </div>
                <div class="servico-item">
                    <div class="srv-icon">🌱</div>
                    <p><strong>Incubação de periódicos emergentes</strong> e inclusão na rede CARINIANA</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipe -->
<section class="sobre-section">
    <div class="container">
        <h2>Nossa Equipe</h2>
        <div class="section-divider"></div>
        <p style="margin-bottom:36px;">Conheça os profissionais que fazem o Portal de Periódicos funcionar.</p>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="equipe-card">
                    <img src="images/ana.png" alt="Ana Roberta Mota">
                    <div class="eq-nome">Ana Roberta Mota</div>
                    <div class="eq-cargo">Bibliotecária</div>
                    <a class="lattes" href="http://lattes.cnpq.br/6636072425703164" target="_blank">Currículo Lattes</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="equipe-card">
                    <img src="images/cassandra.jpg" alt="Cassandra Campos">
                    <div class="eq-nome">Cassandra Campos</div>
                    <div class="eq-cargo">Editora de Publicações</div>
                    <a class="lattes" href="http://lattes.cnpq.br/8767155212928230" target="_blank">Currículo Lattes</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="equipe-card">
                    <img src="images/fabi.png" alt="Fabiana França">
                    <div class="eq-nome">Fabiana França</div>
                    <div class="eq-cargo">Bibliotecária</div>
                    <div class="eq-obs">(em licença)</div>
                    <a class="lattes" href="http://lattes.cnpq.br/0843349256910839" target="_blank">Currículo Lattes</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.html'; ?>
