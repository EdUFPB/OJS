<?php include 'header.html'; ?>

<?php
$periodicos = [
    ['titulo'=>'Acta Semiótica et Lingvistica',
     'subtitulo'=>'Programa de Pós-Graduação em Letras – UFPB',
     'caminho'=>'actas', 'issn'=>'0102-4264',
     'img'=>'images/acta.png',
     'desc'=>'Periódico científico internacional, quadrimestral, dedicado ao intercâmbio entre pesquisadores de Semiótica e Linguística, Literatura Popular, Libras e Braile.'],

    ['titulo'=>'Pesquisa Brasileira em Ciência da Informação e Biblioteconomia',
     'subtitulo'=>'PBCIB',
     'caminho'=>'pbcib', 'issn'=>'1981-0695',
     'img'=>'images/pbcib.png',
     'desc'=>'Editada pelo Grupo de Pesquisa Informação e Inclusão Social (CNPq) em parceria com o Laboratório de Tecnologias Intelectuais da UFPB.'],

    ['titulo'=>'Revista Nordestina de Biologia',
     'subtitulo'=>'Departamento de Sistemática e Ecologia – UFPB',
     'caminho'=>'revnebio', 'issn'=>'2236-1480',
     'img'=>'',
     'desc'=>'Publicação científica dedicada à Biologia, com ênfase em estudos realizados na região Nordeste do Brasil.'],

    ['titulo'=>'The Brazilian Trombone Association Journal',
     'subtitulo'=>'Associação Brasileira de Trombone',
     'caminho'=>'btaj', 'issn'=>'2595-1238',
     'img'=>'',
     'desc'=>'Periódico da Associação Brasileira de Trombone, voltado à pesquisa e divulgação científica em música e performance de trombone.'],

    ['titulo'=>'Métodos e Pesquisa em Administração',
     'subtitulo'=>'MEPAD',
     'caminho'=>'mepad', 'issn'=>'2525-3867',
     'img'=>'images/mepad.png',
     'desc'=>'Publicação voltada à divulgação de pesquisas em Administração, com ênfase em métodos quantitativos e qualitativos aplicados à gestão.'],

    ['titulo'=>'Data Science and Business Review',
     'subtitulo'=>'DSBR',
     'caminho'=>'dsbr', 'issn'=>'2764-2682',
     'img'=>'',
     'desc'=>'Publicação dedicada à ciência de dados aplicada a contextos de negócios e gestão empresarial.'],

    ['titulo'=>'Revista PRÁXIS: Educação e Diversidade',
     'subtitulo'=>'Centro de Educação – UFPB',
     'caminho'=>'prx', 'issn'=>'2525-5355',
     'img'=>'',
     'desc'=>'Publicação voltada à pesquisa em Educação, com ênfase em diversidade, inclusão e práxis pedagógica.'],

    ['titulo'=>'Gênero &amp; Direito',
     'subtitulo'=>'Centro de Ciências Jurídicas – UFPB',
     'caminho'=>'ged', 'issn'=>'2179-7137',
     'img'=>'images/genero-direito.png',
     'desc'=>'Estimula o debate e a produção científica interdisciplinar sobre gênero e Direito, com foco na isonomia e transformação social.'],

    ['titulo'=>'Imaginário!',
     'subtitulo'=>'Pós-Graduação em Letras – UFPB',
     'caminho'=>'imgn', 'issn'=>'2237-6933',
     'img'=>'',
     'desc'=>'Revista acadêmica dedicada ao imaginário, às artes e às humanidades, com publicação de artigos, ensaios e resenhas.'],

    ['titulo'=>'Diversidade Religiosa',
     'subtitulo'=>'Pós-Graduação em Ciências das Religiões – UFPB',
     'caminho'=>'dr', 'issn'=>'2317-0476',
     'img'=>'',
     'desc'=>'Publicação dedicada ao estudo da diversidade religiosa e das culturas, fomentando o diálogo inter-religioso e a pesquisa nas Ciências das Religiões.'],

    ['titulo'=>'Informação &amp; Tecnologia',
     'subtitulo'=>'Ciência da Informação e Arquivologia – UFPB',
     'caminho'=>'itec', 'issn'=>'2358-3908',
     'img'=>'',
     'desc'=>'Publicação dedicada à pesquisa em Ciência da Informação, Arquivologia e Biblioteconomia, com ênfase nas interfaces com as tecnologias digitais.'],

    ['titulo'=>'Revista Economia e Desenvolvimento',
     'subtitulo'=>'Pós-Graduação em Economia – UFPB',
     'caminho'=>'economia', 'issn'=>'2358-2510',
     'img'=>'',
     'desc'=>'Publicação científica voltada às áreas de Economia e Desenvolvimento Regional, com destaque para temas de economia nordestina.'],

    ['titulo'=>'Revista Logos &amp; Existência',
     'subtitulo'=>'Teologia e Ciências das Religiões – UFPB',
     'caminho'=>'le', 'issn'=>'2316-9923',
     'img'=>'',
     'desc'=>'Periódico dedicado ao estudo das interfaces entre fé, razão e existência, nas perspectivas da Teologia e das Ciências das Religiões.'],

    ['titulo'=>'Revista Paraibana de História',
     'subtitulo'=>'Departamento de História – UFPB',
     'caminho'=>'rph', 'issn'=>'2446-5852',
     'img'=>'',
     'desc'=>'Publicação dedicada à pesquisa histórica com ênfase na história da Paraíba e do Nordeste.'],

    ['titulo'=>'Cultura Oriental',
     'subtitulo'=>'Letras Orientais – UFPB',
     'caminho'=>'co', 'issn'=>'2358-5021',
     'img'=>'',
     'desc'=>'Publicação dedicada ao estudo das línguas, literaturas e culturas orientais no contexto brasileiro e ibero-americano.'],

    ['titulo'=>'Turis Nostrum',
     'subtitulo'=>'Pós-Graduação em Turismo – UFPB',
     'caminho'=>'tn', 'issn'=>'2316-4530',
     'img'=>'images/tn.jpg',
     'desc'=>'Periódico semestral dedicado à divulgação de artigos e resenhas sobre Turismo, com ênfase em cultura e desenvolvimento.'],

    ['titulo'=>'Extensão Cidadã',
     'subtitulo'=>'Revista Eletrônica – UFPB',
     'caminho'=>'extensaocidada', 'issn'=>'1982-2138',
     'img'=>'images/extensaocidada.jpg',
     'desc'=>'Divulga ações e reflexões sobre extensão universitária, fomentando o diálogo entre a universidade e a sociedade.'],

    ['titulo'=>'Teoria Política &amp; Social',
     'subtitulo'=>'Pós-Graduação em Serviço Social – UFPB',
     'caminho'=>'tps', 'issn'=>'2176-5332',
     'img'=>'images/tps.jpg',
     'desc'=>'Periódico semestral dedicado às temáticas da política e do social, comprometido com a democracia e a justiça social.'],

    ['titulo'=>'Verba Juris',
     'subtitulo'=>'Anuário da Pós-Graduação em Direito – UFPB',
     'caminho'=>'vj', 'issn'=>'1678-183X',
     'img'=>'images/vj.jpg',
     'desc'=>'Publicação anual do Programa de Pós-Graduação em Ciências Jurídicas da UFPB, voltada à difusão de pesquisas no campo do Direito e suas interfaces.'],

    ['titulo'=>'Revista PetrART',
     'subtitulo'=>'Arte Rupestre e Patrimônio Arqueológico',
     'caminho'=>'petrart', 'issn'=>'',
     'img'=>'',
     'desc'=>'Publicação dedicada à arte rupestre e ao patrimônio arqueológico do Nordeste brasileiro.'],

    ['titulo'=>'AUTOGESTÃO',
     'subtitulo'=>'Economia dos Trabalhadores &amp; Educação Popular',
     'caminho'=>'autogestao', 'issn'=>'',
     'img'=>'images/autogestao.png',
     'desc'=>'Periódico do NUPLAR/UFPB dedicado ao campo transdisciplinar da autogestão social, economia solidária e educação popular.'],

    ['titulo'=>'Revista Estudos Geoambientais',
     'subtitulo'=>'Ecologia – UFPB',
     'caminho'=>'geo', 'issn'=>'',
     'img'=>'images/geo.jpg',
     'desc'=>'Publicação quadrimestral vinculada ao grupo GeodiversidadePB, dedicada à Geografia, Geologia, Climatologia, Gestão Ambiental e Ecologia.'],

    ['titulo'=>'Comunicação Audiovisual',
     'subtitulo'=>'Graduação em Radialismo – UFPB',
     'caminho'=>'palavrar', 'issn'=>'',
     'img'=>'',
     'desc'=>'Publicação semestral que divulga TCCs e artigos do curso de Radialismo da UFPB, estimulando a pesquisa e a iniciação científica no audiovisual.'],

    ['titulo'=>'Revista de Arqueologia',
     'subtitulo'=>'Sociedade de Arqueologia Brasileira',
     'caminho'=>'ra', 'issn'=>'',
     'img'=>'images/ra.png',
     'desc'=>'Publicação da Sociedade de Arqueologia Brasileira, referência na difusão de pesquisas arqueológicas nacionais e internacionais.'],
];

$total = count($periodicos);
?>

<style>
/* ── Acessibilidade ── */
.sr-only {
    position:absolute; width:1px; height:1px; padding:0; margin:-1px;
    overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
}
:focus-visible { outline:3px solid #E8682A; outline-offset:3px; }

/* ── Hero ── */
#nc-hero {
    background: linear-gradient(135deg, #3a3a3a 0%, #555 100%);
    padding: 70px 0 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
#nc-hero::before {
    content:''; position:absolute; top:-60px; right:-60px;
    width:280px; height:280px; border-radius:50%;
    background:rgba(255,255,255,0.05); pointer-events:none;
}
#nc-hero::after {
    content:''; position:absolute; bottom:-80px; left:-40px;
    width:220px; height:220px; border-radius:50%;
    background:rgba(255,255,255,0.04); pointer-events:none;
}
#nc-hero .hero-content { position:relative; z-index:2; }
#nc-hero h1 { font-size:2.2rem; font-weight:800; color:#fff !important; margin-bottom:12px; letter-spacing:-0.02em; }
#nc-hero p  { font-size:1.05rem; opacity:.88; color:#fff !important; max-width:560px; margin:0 auto 24px; }
#nc-hero .hero-wave { position:absolute; bottom:0; left:0; right:0; line-height:0; }

/* ── Stats ── */
.nc-stats { display:flex; justify-content:center; gap:32px; flex-wrap:wrap; margin-top:28px; }
.nc-stats > div { color:#fff; text-align:center; }
.nc-stats .num { font-size:1.9rem; font-weight:800; line-height:1; }
.nc-stats .lab { font-size:.78rem; opacity:.8; margin-top:3px; letter-spacing:.05em; }

/* ── Busca ── */
.search-bar-wrap { max-width:520px; margin:0 auto; position:relative; }
.search-bar-wrap input {
    width:100%; border:none; border-radius:40px;
    padding:13px 48px 13px 22px; font-size:1rem;
    background:#f2f4f6;
    box-shadow:0 4px 20px rgba(0,0,0,0.15);
    outline:none; color:#3a3a3a;
}
.search-bar-wrap input:focus { box-shadow:0 4px 20px rgba(0,0,0,0.25); }
.search-bar-wrap .search-icon {
    position:absolute; right:18px; top:50%; transform:translateY(-50%);
    font-size:1.1rem; color:#aaa; pointer-events:none;
}

/* ── Corpo ── */
#nc-lista { background:#f0f2f5; padding:40px 0 64px; }

/* ── Grid ── */
.nc-grid {
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap:18px;
}

/* ── Card ── */
.nc-card {
    background:#fff;
    border-radius:12px;
    border:1px solid #e8e8e8;
    box-shadow:0 1px 3px rgba(0,0,0,0.06), 0 3px 10px rgba(0,0,0,0.05);
    display:flex; flex-direction:column;
    transition:box-shadow .2s, transform .18s;
    overflow:hidden;
}
.nc-card:hover {
    box-shadow:0 4px 20px rgba(0,0,0,0.12);
    transform:translateY(-2px);
}
.nc-card.oculto { display:none; }

/* Cabeçalho */
.nc-card .card-head {
    display:flex; align-items:flex-start; gap:12px;
    padding:16px 18px 10px;
}
.nc-card .card-thumb {
    width:48px; height:48px; flex-shrink:0;
    border-radius:8px; overflow:hidden;
    border:1px solid rgba(0,0,0,0.07);
    background:#f7f8fa;
    display:flex; align-items:center; justify-content:center;
}
.nc-card .card-thumb img {
    width:100%; height:100%;
    object-fit:contain; padding:4px;
}
.nc-card .card-thumb-letter {
    width:48px; height:48px; flex-shrink:0;
    border-radius:8px; background:#5a7fa8;
    display:flex; align-items:center; justify-content:center;
    font-size:1.25rem; font-weight:900; color:#fff;
}
.nc-card .card-head-info { flex:1; min-width:0; }
.nc-card .card-titulo-h { margin:0 0 3px; }
.nc-card .card-titulo {
    font-size:.95rem; font-weight:800; color:#1a1a1a;
    text-decoration:none; line-height:1.3; display:block;
    transition:color .15s;
}
.nc-card .card-titulo:hover { color:#E8682A; text-decoration:none; }
.nc-card .card-titulo-nolink {
    font-size:.95rem; font-weight:800; color:#1a1a1a; line-height:1.3; display:block;
}
.nc-card .card-subtitulo { font-size:.78rem; font-weight:400; color:#b0b0b0; }

/* Corpo */
.nc-card .card-body {
    padding:0 18px 16px;
    flex:1; display:flex; flex-direction:column;
}
.nc-card .card-desc { font-size:.82rem; color:#555; line-height:1.62; flex:1; margin-bottom:14px; }
.nc-card .card-footer {
    display:flex; align-items:center; justify-content:space-between;
    gap:8px; padding-top:10px; margin-bottom:10px;
    border-top:1px solid #f0f0f0;
}
.card-issn { font-size:.72rem; color:#c8c8c8; }
.card-contact { font-size:.72rem; font-weight:600; color:#E8682A; text-decoration:none; }
.card-contact:hover { text-decoration:underline; }

/* Botões */
.nc-card .card-actions { display:flex; gap:8px; }
.nc-card .card-actions a {
    display:flex; align-items:center; justify-content:center;
    flex:1; min-height:44px;
    border-radius:8px; font-size:.80rem; font-weight:600;
    text-decoration:none;
    transition:filter .15s, transform .1s;
}
.nc-card .card-actions a:hover { filter:brightness(.87); transform:translateY(-1px); text-decoration:none; }
.nc-card .card-actions a:focus-visible { outline:3px solid #E8682A; outline-offset:2px; }
.btn-acesso { background:#E8682A; color:#fff !important; }
.btn-edicao { background:#eef0f3; color:#444 !important; }

/* ── Sem resultados ── */
#sem-resultados { display:none; text-align:center; padding:60px 0; color:#888; }
#sem-resultados .icon { font-size:2.5rem; margin-bottom:12px; }

/* ── Aviso ── */
.nc-aviso {
    font-size:.78rem; color:#aaa; text-align:center;
    margin-top:36px; padding-top:20px;
    border-top:1px solid #e4e4e4;
}

/* ── Responsivo ── */
@media(max-width:767px){
    #nc-hero h1 { font-size:1.5rem; }
    .search-bar-wrap input { font-size:.95rem; }
    .nc-stats .num { font-size:1.5rem; }
}
</style>

<!-- Hero -->
<section id="nc-hero">
    <div class="container hero-content">
        <h1>Periódicos Não Correntes</h1>
        <p>Revistas científicas da UFPB que encerraram suas atividades ou estão temporariamente inativas no portal.</p>

        <div role="search" class="search-bar-wrap">
            <label for="buscaInput" class="sr-only">Pesquisar periódico por título ou ISSN</label>
            <input type="search" id="buscaInput"
                   placeholder="Pesquise por título ou ISSN…"
                   oninput="filtrar()"
                   autocomplete="off">
            <span class="search-icon" aria-hidden="true">🔍</span>
        </div>

        <div class="nc-stats">
            <div><div class="num"><?=$total?></div><div class="lab">Periódicos não correntes</div></div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%;height:48px;display:block;">
            <path d="M0,32 C360,0 1080,60 1440,20 L1440,48 L0,48 Z" fill="#f0f2f5"/>
        </svg>
    </div>
</section>

<!-- Lista -->
<section id="nc-lista">
<div class="container">

<div class="nc-grid" id="nc-grid">
<?php foreach($periodicos as $p):
    $tPlain = html_entity_decode(strip_tags($p['titulo']), ENT_QUOTES, 'UTF-8');
    $letra  = mb_strtoupper(mb_substr($tPlain, 0, 1, 'UTF-8'), 'UTF-8');
    $hasImg  = !empty($p['img']);
    $hasLink = !empty($p['caminho']);
    $hasISSN = !empty($p['issn']);
?>
<article class="nc-card"
     data-titulo="<?=htmlspecialchars(mb_strtolower($tPlain,'UTF-8'))?>"
     data-issn="<?=htmlspecialchars($p['issn'])?>">

    <div class="card-head">
        <?php if($hasImg): ?>
        <div class="card-thumb">
            <img src="<?=$p['img']?>" alt="Logo <?=htmlspecialchars($tPlain)?>"
                 onerror="this.closest('.card-thumb').outerHTML='<div class=\'card-thumb-letter\' aria-hidden=\'true\'><?=$letra?></div>'">
        </div>
        <?php else: ?>
        <div class="card-thumb-letter" aria-hidden="true"><?=$letra?></div>
        <?php endif; ?>

        <div class="card-head-info">
            <h3 class="card-titulo-h">
                <?php if($hasLink): ?>
                <a class="card-titulo"
                   href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>"
                   target="_blank" rel="noopener noreferrer"><?=$p['titulo']?></a>
                <?php else: ?>
                <span class="card-titulo-nolink"><?=$p['titulo']?></span>
                <?php endif; ?>
            </h3>
            <?php if(!empty($p['subtitulo'])): ?>
            <div class="card-subtitulo"><?=$p['subtitulo']?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card-body">
        <p class="card-desc"><?=$p['desc']?></p>

        <?php if($hasISSN || $hasLink): ?>
        <div class="card-footer">
            <?php if($hasISSN): ?>
            <span class="card-issn">ISSN <?=$p['issn']?></span>
            <?php else: ?>
            <span></span>
            <?php endif; ?>
            <?php if($hasLink): ?>
            <a class="card-contact"
               href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>/about/contact"
               target="_blank" rel="noopener noreferrer"
               aria-label="Contato de <?=htmlspecialchars($tPlain)?>">Contato</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if($hasLink): ?>
        <div class="card-actions">
            <a class="btn-acesso"
               href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>"
               target="_blank" rel="noopener noreferrer"
               aria-label="Acessar <?=htmlspecialchars($tPlain)?>">Acessar</a>
            <a class="btn-edicao"
               href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>/issue/current"
               target="_blank" rel="noopener noreferrer"
               aria-label="Edição atual de <?=htmlspecialchars($tPlain)?>">Edição Atual</a>
        </div>
        <?php endif; ?>
    </div>
</article>
<?php endforeach; ?>
</div><!-- /.nc-grid -->

<div id="sem-resultados" role="status" aria-live="polite">
    <div class="icon">🔍</div>
    <p>Nenhum periódico encontrado para esta busca.</p>
</div>

<p class="nc-aviso">
    Periódicos não correntes são revistas que encerraram suas publicações ou estão temporariamente inativas no Portal de Periódicos da UFPB.
</p>

</div>
</section>

<script>
function removerAcentos(s){ return s.normalize('NFD').replace(/[̀-ͯ]/g,'').toLowerCase(); }

function filtrar(){
    var q = removerAcentos(document.getElementById('buscaInput').value.trim());
    var total = 0;
    document.querySelectorAll('.nc-card').forEach(function(card){
        var titulo = removerAcentos(card.dataset.titulo||'');
        var issn   = (card.dataset.issn||'').replace(/-/g,'');
        var qTerm  = q.replace(/-/g,'');
        var show   = !q || titulo.indexOf(q)>=0 || issn.indexOf(qTerm)>=0;
        card.classList.toggle('oculto', !show);
        if(show) total++;
    });
    document.getElementById('sem-resultados').style.display = total===0 ? 'block' : 'none';
}
</script>

<?php include 'footer.html'; ?>
