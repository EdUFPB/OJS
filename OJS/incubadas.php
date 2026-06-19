<?php include 'header.html'; ?>

<?php
$periodicos = [
    ['titulo'=>'Perg@minho',
     'subtitulo'=>'Revista Discente de História – UFPB',
     'caminho'=>'perg', 'issn'=>'3086-2299',
     'img'=>'images/pergaminho.jpg',
     'desc'=>'Editada semestralmente pelo Curso de História e PPGH da UFPB, aceita submissões de alunos de graduação e pós-graduação em História e áreas conexas das Ciências Humanas.'],

    ['titulo'=>'Sudamerica',
     'subtitulo'=>'Revista Internacional de Direitos Humanos',
     'caminho'=>'sda', 'issn'=>'3086-3562',
     'img'=>'images/sudamerica.jpg',
     'desc'=>'Periódico internacional dedicado à pesquisa e debate em Direitos Humanos, com enfoque nos contextos e perspectivas da América do Sul.'],

      ['titulo'=>'Ostium Solis',
     'subtitulo'=>'Revista de Filosofia',
     'caminho'=>'ros', 'issn'=>'',
     'img'=>'images/ostiumSolis.jpg',
     'desc'=>'A Revista Ostium Solis publica trabalhos de filosofia elaborados por graduandos, graduados, mestrandos, mestres, doutorandos e doutores, sem distinções.'],
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
#inc-hero {
    background: linear-gradient(135deg, #1e4a7a 0%, #2d6fad 100%);
    padding: 70px 0 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
#inc-hero::before {
    content:''; position:absolute; top:-60px; right:-60px;
    width:280px; height:280px; border-radius:50%;
    background:rgba(255,255,255,0.05); pointer-events:none;
}
#inc-hero::after {
    content:''; position:absolute; bottom:-80px; left:-40px;
    width:220px; height:220px; border-radius:50%;
    background:rgba(255,255,255,0.04); pointer-events:none;
}
#inc-hero .hero-content { position:relative; z-index:2; }
#inc-hero h1 { font-size:2.2rem; font-weight:800; color:#fff !important; margin-bottom:12px; letter-spacing:-0.02em; }
#inc-hero p  { font-size:1.05rem; opacity:.88; color:#fff !important; max-width:560px; margin:0 auto 24px; }
#inc-hero .hero-wave { position:absolute; bottom:0; left:0; right:0; line-height:0; }

/* ── Stats ── */
.inc-stats { display:flex; justify-content:center; gap:32px; flex-wrap:wrap; margin-top:28px; }
.inc-stats > div { color:#fff; text-align:center; }
.inc-stats .num { font-size:1.9rem; font-weight:800; line-height:1; }
.inc-stats .lab { font-size:.78rem; opacity:.8; margin-top:3px; letter-spacing:.05em; }

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
#inc-lista { background:#f0f2f5; padding:40px 0 64px; }

/* ── Grid ── */
.inc-grid {
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap:18px;
}

/* ── Card ── */
.inc-card {
    background:#fff;
    border-radius:12px;
    border:1px solid #e8e8e8;
    box-shadow:0 1px 3px rgba(0,0,0,0.06), 0 3px 10px rgba(0,0,0,0.05);
    display:flex; flex-direction:column;
    transition:box-shadow .2s, transform .18s;
    overflow:hidden;
}
.inc-card:hover {
    box-shadow:0 4px 20px rgba(0,0,0,0.12);
    transform:translateY(-2px);
}
.inc-card.oculto { display:none; }

/* Cabeçalho */
.inc-card .card-head {
    display:flex; align-items:flex-start; gap:12px;
    padding:16px 18px 10px;
}
.inc-card .card-thumb {
    width:48px; height:48px; flex-shrink:0;
    border-radius:8px; overflow:hidden;
    border:1px solid rgba(0,0,0,0.07);
    background:#f7f8fa;
    display:flex; align-items:center; justify-content:center;
}
.inc-card .card-thumb img {
    width:100%; height:100%;
    object-fit:contain; padding:4px;
}
.inc-card .card-thumb-letter {
    width:48px; height:48px; flex-shrink:0;
    border-radius:8px; background:#2d6fad;
    display:flex; align-items:center; justify-content:center;
    font-size:1.25rem; font-weight:900; color:#fff;
}
.inc-card .card-head-info { flex:1; min-width:0; }
.inc-card .card-titulo-h { margin:0 0 3px; }
.inc-card .card-titulo {
    font-size:.95rem; font-weight:800; color:#1a1a1a;
    text-decoration:none; line-height:1.3; display:block;
    transition:color .15s;
}
.inc-card .card-titulo:hover { color:#E8682A; text-decoration:none; }
.inc-card .card-subtitulo { font-size:.78rem; font-weight:400; color:#b0b0b0; }

/* Corpo */
.inc-card .card-body {
    padding:0 18px 16px;
    flex:1; display:flex; flex-direction:column;
}
.inc-card .card-desc { font-size:.82rem; color:#555; line-height:1.62; flex:1; margin-bottom:14px; }
.inc-card .card-footer {
    display:flex; align-items:center; justify-content:space-between;
    gap:8px; padding-top:10px; margin-bottom:10px;
    border-top:1px solid #f0f0f0;
}
.card-issn { font-size:.72rem; color:#c8c8c8; }
.card-contact { font-size:.72rem; font-weight:600; color:#E8682A; text-decoration:none; }
.card-contact:hover { text-decoration:underline; }

/* Botões */
.inc-card .card-actions { display:flex; gap:8px; }
.inc-card .card-actions a {
    display:flex; align-items:center; justify-content:center;
    flex:1; min-height:44px;
    border-radius:8px; font-size:.80rem; font-weight:600;
    text-decoration:none;
    transition:filter .15s, transform .1s;
}
.inc-card .card-actions a:hover { filter:brightness(.87); transform:translateY(-1px); text-decoration:none; }
.inc-card .card-actions a:focus-visible { outline:3px solid #E8682A; outline-offset:2px; }
.btn-acesso { background:#E8682A; color:#fff !important; }
.btn-edicao { background:#eef0f3; color:#444 !important; }

/* ── Sem resultados ── */
#sem-resultados { display:none; text-align:center; padding:60px 0; color:#888; }
#sem-resultados .icon { font-size:2.5rem; margin-bottom:12px; }

/* ── Aviso ── */
.inc-aviso {
    font-size:.78rem; color:#aaa; text-align:center;
    margin-top:36px; padding-top:20px;
    border-top:1px solid #e4e4e4;
}

/* ── Responsivo ── */
@media(max-width:767px){
    #inc-hero h1 { font-size:1.5rem; }
    .search-bar-wrap input { font-size:.95rem; }
    .inc-stats .num { font-size:1.5rem; }
}
</style>

<!-- Hero -->
<section id="inc-hero">
    <div class="container hero-content">
        <h1>Periódicos Incubados</h1>
        <p>Revistas científicas da UFPB em fase de desenvolvimento e consolidação no portal.</p>

        <div role="search" class="search-bar-wrap">
            <label for="buscaInput" class="sr-only">Pesquisar periódico por título ou ISSN</label>
            <input type="search" id="buscaInput"
                   placeholder="Pesquise por título ou ISSN…"
                   oninput="filtrar()"
                   autocomplete="off">
            <span class="search-icon" aria-hidden="true">🔍</span>
        </div>

        <div class="inc-stats">
            <div><div class="num"><?=$total?></div><div class="lab">Periódicos incubados</div></div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%;height:48px;display:block;">
            <path d="M0,32 C360,0 1080,60 1440,20 L1440,48 L0,48 Z" fill="#f0f2f5"/>
        </svg>
    </div>
</section>

<!-- Lista -->
<section id="inc-lista">
<div class="container">

<div class="inc-grid" id="inc-grid">
<?php foreach($periodicos as $p):
    $tPlain = html_entity_decode(strip_tags($p['titulo']), ENT_QUOTES, 'UTF-8');
    $letra  = mb_strtoupper(mb_substr($tPlain, 0, 1, 'UTF-8'), 'UTF-8');
    $hasImg  = !empty($p['img']);
    $hasISSN = !empty($p['issn']);
?>
<article class="inc-card"
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
                <a class="card-titulo"
                   href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>"
                   target="_blank" rel="noopener noreferrer"><?=$p['titulo']?></a>
            </h3>
            <?php if(!empty($p['subtitulo'])): ?>
            <div class="card-subtitulo"><?=$p['subtitulo']?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card-body">
        <p class="card-desc"><?=$p['desc']?></p>

        <div class="card-footer">
            <?php if($hasISSN): ?>
            <span class="card-issn">ISSN <?=$p['issn']?></span>
            <?php else: ?>
            <span></span>
            <?php endif; ?>
            <a class="card-contact"
               href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>/about/contact"
               target="_blank" rel="noopener noreferrer"
               aria-label="Contato de <?=htmlspecialchars($tPlain)?>">Contato</a>
        </div>

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
    </div>
</article>
<?php endforeach; ?>
</div><!-- /.inc-grid -->

<div id="sem-resultados" role="status" aria-live="polite">
    <div class="icon">🔍</div>
    <p>Nenhum periódico encontrado para esta busca.</p>
</div>

<p class="inc-aviso">
    Periódicos incubados são revistas científicas em fase de desenvolvimento e consolidação, apoiadas pelo Portal de Periódicos da UFPB.
</p>

</div>
</section>

<script>
function removerAcentos(s){ return s.normalize('NFD').replace(/[̀-ͯ]/g,'').toLowerCase(); }

function filtrar(){
    var q = removerAcentos(document.getElementById('buscaInput').value.trim());
    var total = 0;
    document.querySelectorAll('.inc-card').forEach(function(card){
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
