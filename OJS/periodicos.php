<?php include 'header.html'; ?>

<?php
$periodicos = [
    // A1
    ['titulo'=>'Moringa',                  'subtitulo'=>'Artes do Espetáculo',
     'caminho'=>'moringa',     'qualis'=>'A1', 'issn'=>'2177-8841',
     'img'=>'images/moringa.png',
     'desc'=>'Diálogo interdisciplinar nas artes cênicas — criação, poéticas espetaculares e relações com a cultura.'],

    ['titulo'=>'Problemata',               'subtitulo'=>'Revista Internacional de Filosofia',
     'caminho'=>'problemata',  'qualis'=>'A1', 'issn'=>'2236-8612',
     'img'=>'images/problemata.png',
     'desc'=>'Publica artigos, traduções e resenhas filosóficas em português, francês, espanhol, italiano e alemão.'],

    // A2
    ['titulo'=>'Aufklärung',               'subtitulo'=>'Journal of Philosophy',
     'caminho'=>'arf',         'qualis'=>'A2', 'issn'=>'2318-9428',
     'img'=>'images/auk.png',
     'desc'=>'Espaço aberto ao debate filosófico entre pesquisadores do Brasil e do exterior, com ênfase em ética e epistemologia.'],

    ['titulo'=>'Informação &amp; Sociedade', 'subtitulo'=>'Estudos',
     'caminho'=>'ies',         'qualis'=>'A2', 'issn'=>'1809-4783',
     'img'=>'images/informacao_e_sociedade.png',
     'desc'=>'Uma das primeiras revistas brasileiras de Ciência da Informação indexada no Journal Citation Reports (JCR), publicada desde 1991.'],

    ['titulo'=>'Okara',                    'subtitulo'=>'Geografia em Debate',
     'caminho'=>'okara',       'qualis'=>'A2', 'issn'=>'1982-3878',
     'img'=>'images/okara.png',
     'desc'=>'Fomenta o debate geográfico entre pesquisadores, docentes e profissionais, com foco em teoria e prática da Geografia.'],

    ['titulo'=>'Revista Ártemis',          'subtitulo'=>'Gênero, Feminismos e Sexualidades',
     'caminho'=>'artemis',     'qualis'=>'A2', 'issn'=>'1807-8214',
     'img'=>'images/artemis.png',
     'desc'=>'Produção científica interdisciplinar sobre gênero, feminismos e sexualidades sob perspectivas históricas, literárias e culturais.'],

    ['titulo'=>'Sæculum',                  'subtitulo'=>'Revista de História',
     'caminho'=>'srh',         'qualis'=>'A2', 'issn'=>'2317-6725',
     'img'=>'images/saeculum2.png',
     'desc'=>'Publicação do PPGH/UFPB voltada para pesquisas em História, Cultura Histórica e interfaces com outras áreas.'],

    // A3
    ['titulo'=>'Claves',                   'subtitulo'=>'Música e Pesquisa',
     'caminho'=>'claves',      'qualis'=>'A3', 'issn'=>'1983-3709',
     'img'=>'images/claves.png',
     'desc'=>'Periódico do PPGM/UFPB dedicado à Composição, Educação Musical, Musicologia e Práticas Interpretativas.'],

    ['titulo'=>'Política &amp; Trabalho',  'subtitulo'=>'Revista de Ciências Sociais',
     'caminho'=>'politicaetrabalho', 'qualis'=>'A3', 'issn'=>'1517-5901',
     'img'=>'images/politicaetrabalho2.png',
     'desc'=>'Publicação do PPGS/UFPB com mais de 30 anos de debate qualificado em Sociologia, Política e Antropologia.'],

    ['titulo'=>'Espaço do Currículo',      'subtitulo'=>'GEPPC – UFPB',
     'caminho'=>'rec',         'qualis'=>'A3', 'issn'=>'1983-1579',
     'img'=>'images/revista-espaco-do-curriculo.png',
     'desc'=>'Periódico do GEPPC/UFPB, criado em 2008, dedicado ao debate nacional e internacional sobre políticas e estudos curriculares na Educação.'],

    ['titulo'=>'Temas em Educação',        'subtitulo'=>'PPGE – UFPB',
     'caminho'=>'rteo',        'qualis'=>'A3', 'issn'=>'0104-2777',
     'img'=>'images/rte.png',
     'desc'=>'Fundada em 1991 e online desde 2009, é organizada pelo PPGE/UFPB prioriza pesquisas científicas nacionais e internacionais em Educação.'],

    ['titulo'=>'Âncora',                   'subtitulo'=>'Revista de Jornalismo',
     'caminho'=>'ancora',      'qualis'=>'A3', 'issn'=>'2359-375X',
     'img'=>'images/ancora.png',
     'desc'=>'Voltada para a pesquisa em Jornalismo na perspectiva latino-americana, com diálogos entre comunicação e cultura.'],

    // A4
    ['titulo'=>'Biblionline',              'subtitulo'=>'DCI – UFPB',
     'caminho'=>'biblio',      'qualis'=>'A4', 'issn'=>'1809-4775',
     'img'=>'images/biblionline.png',
     'desc'=>'Publicada ininterruptamente desde 2005 nas áreas de Biblioteconomia, Arquivologia, Ciência da Informação e Museologia com acesso aberto e avaliação por pares.'],

    ['titulo'=>'Prolíngua',               'subtitulo'=>'Linguística – UFPB',
     'caminho'=>'prolingua',   'qualis'=>'A4', 'issn'=>'1983-9979',
     'img'=>'images/prolingua.png',
     'desc'=>'Espaço consolidado de divulgação de pesquisas teóricas e aplicadas em Linguística, promovendo o debate entre pesquisadores nacionais e internacionais.'],

    ['titulo'=>'Revista Brasileira de Políticas Públicas e Internacionais',                     'subtitulo'=>'RPPI',
     'caminho'=>'rppi',        'qualis'=>'A4', 'issn'=>'2525-5584',
     'img'=>'images/rppi.png',
     'desc'=>'A Revista Brasileira de Políticas Públicas e Internacionais aborda Gestão Pública e Políticas Públicas nos planos doméstico e internacional.'],

    ['titulo'=>'RECFin',                   'subtitulo'=>'Evidenciação Contábil &amp; Finanças',
     'caminho'=>'recfin',      'qualis'=>'A4', 'issn'=>'2318-1001',
     'img'=>'images/recfin.png',
     'desc'=>'Reúne estudos voltados à Contabilidade, Atuária e Finanças, abordando temas relacionados à gestão, mercados, educação e inovação, com foco na produção e disseminação do conhecimento científico.'],

    ['titulo'=>'Scandia',                  'subtitulo'=>'Journal of Medieval Norse Studies',
     'caminho'=>'scandia',     'qualis'=>'A4', 'issn'=>'2595-9107',
     'img'=>'images/scandia.png',
     'desc'=>'Especializada em Estudos Nórdicos Medievais, publica pesquisas sobre a Era Viking e o mundo escandinavo, contemplando abordagens em história, mitologia, religião, literatura e arqueologia.'],

    ['titulo'=>'Teoria e Prática em Administração', 'subtitulo'=>'PPGA – UFPB',
     'caminho'=>'tpa',         'qualis'=>'A4', 'issn'=>'2238-104X',
     'img'=>'images/tpa.png',
     'desc'=>'Periódico do PPGA/UFPB voltado a executivos, gestores públicos, empreendedores e docentes — dissemina conhecimentos que conectam teoria e prática da Administração.'],

    ['titulo'=>'Áltera',                   'subtitulo'=>'Revista de Antropologia',
     'caminho'=>'altera',      'qualis'=>'A4', 'issn'=>'2447-9837',
     'img'=>'images/altera.png',
     'desc'=>'Espaço dedicado ao debate antropológico contemporâneo, acolhendo diferentes perspectivas teóricas, metodológicas e etnográficas sobre fenômenos sociais, culturais e políticos.'],

    // B1
    ['titulo'=>'Archeion Online',          'subtitulo'=>'Arquivologia – UFPB',
     'caminho'=>'archeion',    'qualis'=>'B1', 'issn'=>'2318-6186',
     'img'=>'images/archeion.png',
     'desc'=>'Periódico semestral vinculado ao curso de Arquivologia da UFPB — publica artigos originais sobre temas relevantes da Arquivologia e áreas afins, cumprindo a missão de produzir e divulgar conhecimento.'],

    ['titulo'=>'Culturas Midiáticas',      'subtitulo'=>'PPGC – UFPB',
     'caminho'=>'cm',          'qualis'=>'B1', 'issn'=>'1983-5930',
     'img'=>'images/culturas-midiaticas.png',
     'desc'=>'Lançada em 2008, publica pesquisas em Comunicação e suas interfaces com culturas audiovisuais, midiatização do cotidiano e do imaginário — incentivando a transdisciplinaridade.'],

    ['titulo'=>'Journal Urban &amp; Environmental Engineering',                     'subtitulo'=>'JUEE',
     'caminho'=>'juee',        'qualis'=>'B1', 'issn'=>'1982-3932',
     'img'=>'images/juee1.png',
     'desc'=>'Focada nos desafios das cidades e do meio ambiente, publica pesquisas sobre recursos hídricos, saneamento, transporte, planejamento urbano e sustentabilidade ambiental.'],

    ['titulo'=>'Letr@ Viv@',              'subtitulo'=>'DLEM – UFPB',
     'caminho'=>'lv',          'qualis'=>'B1', 'issn'=>'1517-3100',
     'img'=>'images/lv.jpg',
     'desc'=>'Periódico do DLEM/UFPB publicado desde 1999, com edição semestral em fluxo contínuo nas áreas de Literatura, Linguística, Tradução, Ensino de Línguas e Formação de Professores.'],

    ['titulo'=>'Perspectivas em Gestão & Conhecimento',               'subtitulo'=>'PG&amp;C',
     'caminho'=>'pgc',         'qualis'=>'B1', 'issn'=>'2236-417X',
     'img'=>'images/pgec.png',
     'desc'=>'A Revista Perspectivas em Gestão e Conhecimento é iniciativa da UFPB em cooperação com o IBICT, publica pesquisas interdisciplinares em gestão do conhecimento, gestão da informação e estudos organizacionais.'],

    ['titulo'=>'Prim Facie',              'subtitulo'=>'Estudos Jurídicos Contemporâneos',
     'caminho'=>'primafacie',  'qualis'=>'B1', 'issn'=>'1678-2593',
     'img'=>'images/prima-facie.png',
     'desc'=>'Dedicado à divulgação de pesquisas inovadoras e ao debate de temas contemporâneos do Direito. Destaca-se pela abordagem interdisciplinar de questões relacionadas aos direitos humanos, desenvolvimento, meio ambiente e justiça social.'],

    ['titulo'=>'Revista Educare',         'subtitulo'=>'DFE/CE – UFPB',
     'caminho'=>'educare',     'qualis'=>'B1', 'issn'=>'2527-1083',
     'img'=>'images/educare.jpg',
     'desc'=>'Iniciativa do DFE/CE/UFPB, publica anualmente trabalhos inéditos nos Fundamentos da Educação em português, espanhol, inglês e outros idiomas, de pesquisadores e pós-graduandos.'],

    ['titulo'=>'Temática',                'subtitulo'=>'NAMID/DEMID – UFPB',
     'caminho'=>'tematica',    'qualis'=>'B1', 'issn'=>'1807-8931',
     'img'=>'images/tematica.jpg',
     'desc'=>'Fundada em 2004, é uma publicação mensal interdisciplinar em Comunicação e áreas afins, integrada ao NAMID/UFPB, com fluxo contínuo aberto a pesquisadores da graduação e pós-graduação.'],

    // B2
    ['titulo'=>'Religare',                'subtitulo'=>'Ciências das Religiões',
     'caminho'=>'religare',    'qualis'=>'B2', 'issn'=>'1982-6605',
     'img'=>'images/religare.png',
     'desc'=>'Periódico do PPGCR/UFPB que publica artigos, resenhas e traduções em Ciências das Religiões e áreas afins.'],

    ['titulo'=>'Revista da ABET',         'subtitulo'=>'Estudos do Trabalho',
     'caminho'=>'abet',        'qualis'=>'B2', 'issn'=>'1679-2483',
     'img'=>'images/abet.png',
     'desc'=>'A Revista da Associação Brasileira de Estudos do Trabalho foi lançada em 2001, reúne pesquisas interdisciplinares sobre o mundo do trabalho — Economia, Sociologia, Direito, História, Saúde e outras áreas.'],

    ['titulo'=>'Revista da Iniciação Científica em Relações Internacionais',                   'subtitulo'=>'RICRI',
     'caminho'=>'ricri',       'qualis'=>'B2', 'issn'=>'2318-9452',
     'img'=>'images/ricri.jpg',
     'desc'=>'Revista da Iniciação científica em Relações Internacionais — incentiva jovens pesquisadores no debate global e diplomático.'],

    // B3
    ['titulo'=>'Cadernos do LOGEPA',      'subtitulo'=>'LOGEPA/GENAT – UFPB',
     'caminho'=>'logepa',      'qualis'=>'B3', 'issn'=>'2237-7522',
     'img'=>'images/cadernos-logepa.png',
     'desc'=>'Vinculada ao LOGEPA/UFPB, publica pesquisas em Geografia, Geomorfologia, gestão de riscos naturais e dinâmicas socioambientais da Paraíba, com volume anual em fluxo contínuo.'],

    ['titulo'=>'CAOS',                    'subtitulo'=>'Ciências Sociais',
     'caminho'=>'caos',        'qualis'=>'B3', 'issn'=>'1517-6916',
     'img'=>'images/caos.png',
     'desc'=>'A Revista Eletrônica de Ciências Sociais é um espaço de diálogo e reflexão nas áreas de Antropologia, Ciência Política e Sociologia, reunindo pesquisas, ensaios e debates sobre questões contemporâneas da sociedade.'],

    ['titulo'=>'DLCV',                    'subtitulo'=>'Língua, Linguística &amp; Literatura',
     'caminho'=>'dclv',        'qualis'=>'B3', 'issn'=>'2237-0900',
     'img'=>'images/dlcv.png',
     'desc'=>'Um espaço para a divulgação e o debate de pesquisas sobre linguagem, literatura e culturas. Publica estudos, ensaios, traduções e resenhas que ampliam as reflexões sobre os múltiplos aspectos das línguas e das práticas literárias.'],

    ['titulo'=>'Gaia Scientia',           'subtitulo'=>'PRODEMA – UFPB',
     'caminho'=>'gaia',        'qualis'=>'B3', 'issn'=>'1981-1268',
     'img'=>'images/gaia.png',
     'desc'=>'Lançada em 2007 pelo PRODEMA/UFPB, publica artigos originais em Ciências Ambientais e suas interfaces com Ecologia, Etnobiologia, Geografia Ambiental, Saúde e Engenharia Ambiental.'],

    ['titulo'=>'Revista Brasileira de Ciências da Saúde',                    'subtitulo'=>'RBCS',
     'caminho'=>'rbcs',        'qualis'=>'B3', 'issn'=>'2317-6032',
     'img'=>'images/rbcs.png',
     'desc'=>'Produção acadêmica em Ciências da Saúde com foco na realidade brasileira e na qualidade da assistência.'],

    ['titulo'=>'Revista Graphos',         'subtitulo'=>'PPGL – UFPB',
     'caminho'=>'graphos',     'qualis'=>'B3', 'issn'=>'2763-9355',
     'img'=>'images/graphos.png',
     'desc'=>'Publicada pelo PPGL/UFPB desde 1995, divulga artigos inéditos de pesquisadores brasileiros e estrangeiros nas áreas de Literatura, Cultura, Teoria Literária e Tradução, com periodicidade quadrimestral.'],

    // B4
    ['titulo'=>'Revista Agropecuária Técnica',    'subtitulo'=>'AGROTEC',
     'caminho'=>'at',          'qualis'=>'B4', 'issn'=>'2525-8990',
     'img'=>'images/at.jpg',
     'desc'=>'Editada pelo CCA/UFPB em fluxo contínuo, publica artigos originais nas Ciências Agrárias — Agronomia, Medicina Veterinária, Zootecnia, Ciências Florestais, Engenharia Agrícola e áreas afins.'],

    ['titulo'=>'Gestão &amp; Aprendizagem', 'subtitulo'=>'PPGOA – UFPB',
     'caminho'=>'mpgoa',       'qualis'=>'B4', 'issn'=>'2526-3102',
     'img'=>'images/mpgoa.jpg',
     'desc'=>'Periódico do PPGOA/UFPB publicado desde 2012, focado nos estudos dos processos de gestão e aprendizagem organizacionais.'],

    ['titulo'=>'Letras et Ideias',        'subtitulo'=>'PPGL/CCHLA – UFPB',
     'caminho'=>'letraseideias','qualis'=>'B4', 'issn'=>'2595-7295',
     'img'=>'images/letraseideias.jpg',
     'desc'=>'Revista eletrônica de acesso livre do PPGL/CCHLA/UFPB, publica trabalhos inéditos em Letras, Linguística, Literatura e áreas afins.'],

    ['titulo'=>'Prosppectus',             'subtitulo'=>'Metodologias Qualitativas',
     'caminho'=>'prosp',       'qualis'=>'B4', 'issn'=>'2763-9606',
     'img'=>'images/prospectus.jpg',
     'desc'=>'Primeiro periódico nacional dedicado a metodologias qualitativas em Contabilidade — vinculado ao DFC/UFPB, com publicação semestral de artigos teórico-empíricos e ensaios teóricos.'],

    ['titulo'=>'Revista Abordagens',      'subtitulo'=>'PPGS – UFPB',
     'caminho'=>'rappgs',      'qualis'=>'B4', 'issn'=>'2674-824X',
     'img'=>'images/rappgs.jpg',
     'desc'=>'Publicação semestral do corpo discente do PPGS/UFPB, com linha editorial plural voltada ao campo sociológico e áreas afins.'],

    ['titulo'=>'Revista Científica de Produção Animal', 'subtitulo'=>'Produção Animal',
     'caminho'=>'rcpa',        'qualis'=>'B4', 'issn'=>'2176-4158',
     'img'=>'images/rcpa.jpg',
     'desc'=>'Vinculado ao CCA/UFPB e a Sociedade Nordestina de Produção Animal desde 1999, publica trabalhos inéditos em Zootecnia — Nutrição Animal, Forragicultura, Genômica, Reprodução e Sistemas de Produção.'],

    ['titulo'=>'LiteralMENTE',            'subtitulo'=>'LIGEPSI – UFPB',
     'caminho'=>'rl',          'qualis'=>'B4', 'issn'=>'2764-4251',
     'img'=>'images/rl.jpg',
     'desc'=>'Periódico semestral do LIGEPSI/UFPB dedicado aos estudos literários e suas interfaces com a Psicanálise — publica artigos, ensaios, resenhas e relatos em fluxo contínuo.'],

    ['titulo'=>'Ratio Iuris',             'subtitulo'=>'CCJ – UFPB',
     'caminho'=>'rri',         'qualis'=>'B4', 'issn'=>'2358-4351',
     'img'=>'images/rri.jpg',
     'desc'=>'Periódico semestral do CCJ/UFPB voltado a incentivar a produção científica na graduação e divulgar a produção intelectual em Direito.'],

    ['titulo'=>'Sanhauá',                 'subtitulo'=>'Revista de Extensão da UFPB',
     'caminho'=>'snh',         'qualis'=>'B4', 'issn'=>'2966-1005',
     'img'=>'images/sanhaua.png',
     'desc'=>'Publicação da PROEX/UFPB que valoriza e divulga as ações de extensão universitária em fluxo contínuo.'],

    // C
    ['titulo'=>'Comunicações em Informática', 'subtitulo'=>'DI – UFPB',
     'caminho'=>'cei',         'qualis'=>'C',  'issn'=>'2595-0622',
     'img'=>'images/cei.jpg',
     'desc'=>'Periódico do Departamento de Informática/UFPB que divulga relatos científicos em Ciência da Computação e suas interfaces com Saúde, Educação, Engenharias e outras áreas.'],

    ['titulo'=>'Direitos Humanos e Transdisciplinaridade',                     'subtitulo'=>'DHT',
     'caminho'=>'dht',         'qualis'=>'C',  'issn'=>'2965-4432',
     'img'=>'images/dht.jpg',
     'desc'=>'A Revista Direitos Humanos e Transdisciplinaridade aborda os direitos humanos sob perspectiva transdisciplinar, integrando Direito, Filosofia e Ciências Sociais.'],

    ['titulo'=>'Caderno de Docências',    'subtitulo'=>'Educação e Ensino',
     'caminho'=>'cad',         'qualis'=>'C',  'issn'=>'2764-7153',
     'img'=>'images/cad.jpg',
     'desc'=>'Periódico de acesso aberto da UFPB dedicado a pesquisas, ensaios e experiências sobre práticas docentes e processos educativos em suas dimensões pedagógicas, éticas e políticas.'],

    ['titulo'=>'Revista de Iniciação Científica em Odontologia',                  'subtitulo'=>'RevICO',
     'caminho'=>'revico',      'qualis'=>'C',  'issn'=>'1677-3527',
     'img'=>'images/revico.png',
     'desc'=>'Incentiva a pesquisa científica em Odontologia, dando voz à produção de graduandos e pós-graduandos.'],

    ['titulo'=>'Revista InterCulturas',   'subtitulo'=>'MINNI Mundo – UFPB/CNPq',
     'caminho'=>'rics',        'qualis'=>'C',  'issn'=>'2966-3997',
     'img'=>'images/rics.jpg',
     'desc'=>'Periódico semestral do grupo MINNI Mundo/UFPB dedicado a mediações interculturais, diplomacia, relações internacionais e processos de negociação em contextos globais.'],

    ['titulo'=>'Revista Medicina &amp; Pesquisa', 'subtitulo'=>'Ciências da Saúde',
     'caminho'=>'rmp',         'qualis'=>'C',  'issn'=>'2525-5851',
     'img'=>'images/rmp.jpg',
     'desc'=>'Periódico interdisciplinar em Ciências da Saúde da UFPB — publica estudos originais, revisões e produções acadêmicas sobre cuidado, prática clínica, educação e sistemas de saúde.'],

    // NC — Não Classificado
    ['titulo'=>'Benjaminiana',           'subtitulo'=>'Estudos em Tradução e Imagem',
     'caminho'=>'breti',       'qualis'=>'NC', 'issn'=>'3086-2396',
     'img'=>'images/breti.jpg',
     'desc'=>'Publicação trimestral especializada em Estudos da Tradução e Imagem, com ênfase na obra de Walter Benjamin e interfaces com Literatura, Semiótica e História da Arte.'],

    ['titulo'=>'Fala Tu!',               'subtitulo'=>'Pedagogia UFPB',
     'caminho'=>'ftu',         'qualis'=>'NC', 'issn'=>'3086-111X',
     'img'=>'images/ftu.jpg',
     'desc'=>'Periódico semestral que socializa a produção acadêmica e literária de graduandos em Pedagogia/CE/UFPB, com espaço plural para diferentes vozes e formas de linguagem.'],

    ['titulo'=>'Revista Discurso &amp; Imagem Visual em Educação', 'subtitulo'=>'RDIVE – GEPDIVE/UFPB',
     'caminho'=>'rdive',       'qualis'=>'NC', 'issn'=>'2526-0839',
     'img'=>'images/rdive.jpg',
     'desc'=>'Publica pesquisas sobre nexos pedagógicos entre discurso, imagem visual e educação, a partir das artes, filosofia, letras e ciências humanas.'],

    ['titulo'=>'Revista Lugares de Educação', 'subtitulo'=>'Educação - CCHSA/UFPB',
     'caminho'=>'rle',         'qualis'=>'NC', 'issn'=>'2237-1451',
     'img'=>'images/rle.jpg',
     'desc'=>'Publicação anual do Departamento de Educação do CCHSA/UFPB, em fluxo contínuo, voltada para estudos e pesquisas em Educação.'],

    ['titulo'=>'Textos NDIHR',           'subtitulo'=>'Memória e História',
     'caminho'=>'ndihr',       'qualis'=>'NC', 'issn'=>'',
     'img'=>'images/ndihr.jpg',
     'desc'=>'Publicação semestral do NDIHR/UFPB, criada em 1985, dedicada à divulgação de estudos e pesquisas nas Humanidades produzidos por professores, alunos e técnicos.'],
];

function qualisCor($q) {
    $map = [
        'A1' => ['bg'=>'#1a6b3a', 'txt'=>'#fff'],
        'A2' => ['bg'=>'#2e8b57', 'txt'=>'#fff'],
        'A3' => ['bg'=>'#52a872', 'txt'=>'#fff'],
        'A4' => ['bg'=>'#82c99a', 'txt'=>'#222'],
        'B1' => ['bg'=>'#E8682A', 'txt'=>'#fff'],
        'B2' => ['bg'=>'#d45a1f', 'txt'=>'#fff'],
        'B3' => ['bg'=>'#c04d12', 'txt'=>'#fff'],
        'B4' => ['bg'=>'#a84110', 'txt'=>'#fff'],
        'C'  => ['bg'=>'#888',    'txt'=>'#fff'],
        'NC' => ['bg'=>'#b0b0b0', 'txt'=>'#fff'],
    ];
    return $map[$q] ?? ['bg'=>'#b0b0b0', 'txt'=>'#fff'];
}

$totalRevistas = count($periodicos);
?>

<style>
/* ── Hero ── */
#per-hero {
    background: linear-gradient(135deg, #E8682A 0%, #c4521a 100%);
    padding: 70px 0 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
#per-hero::before {
    content:''; position:absolute; top:-60px; right:-60px;
    width:280px; height:280px; border-radius:50%;
    background:rgba(255,255,255,0.07); pointer-events:none;
}
#per-hero::after {
    content:''; position:absolute; bottom:-80px; left:-40px;
    width:220px; height:220px; border-radius:50%;
    background:rgba(255,255,255,0.06); pointer-events:none;
}
#per-hero .hero-content { position:relative; z-index:2; }
#per-hero h1 { font-size:2.2rem; font-weight:800; color:#fff !important; margin-bottom:12px; letter-spacing:-0.02em; }
#per-hero p  { font-size:1.05rem; opacity:.92; color:#fff !important; max-width:560px; margin:0 auto 24px; }
#per-hero .hero-wave { position:absolute; bottom:0; left:0; right:0; line-height:0; }

/* ── Stats ── */
.per-stats { display:flex; justify-content:center; gap:32px; flex-wrap:wrap; margin-top:28px; }
.per-stats > div { color:#fff; text-align:center; }
.per-stats .num { font-size:1.9rem; font-weight:800; line-height:1; }
.per-stats .lab { font-size:.78rem; opacity:.8; margin-top:3px; letter-spacing:.05em; }
.per-stats .sep { width:1px; background:rgba(255,255,255,0.3); }

/* ── Busca ── */
.search-bar-wrap { max-width:520px; margin:0 auto; position:relative; }
.search-bar-wrap input {
    width:100%; border:none; border-radius:40px;
    padding:13px 48px 13px 22px; font-size:1rem;
    background:#f2f4f6;
    box-shadow:0 4px 20px rgba(0,0,0,0.15);
    outline:none; color:#3a3a3a;
}
.search-bar-wrap .search-icon {
    position:absolute; right:18px; top:50%; transform:translateY(-50%);
    font-size:1.1rem; color:#aaa; pointer-events:none;
}

/* ── Filtros Qualis ── */
.qualis-filters { display:flex; flex-wrap:wrap; justify-content:center; gap:8px; padding:20px 0 0; }
.qf-btn {
    border:none; border-radius:20px; padding:6px 18px;
    font-size:.82rem; font-weight:600; cursor:pointer;
    transition:opacity .2s, transform .1s; opacity:.72;
}
.qf-btn:hover, .qf-btn.ativo { opacity:1; transform:scale(1.06); }
.qf-btn.todos { background:rgba(255,255,255,0.25); color:#fff; border:1px solid rgba(255,255,255,0.5); }
.qf-btn.todos.ativo { background:#fff; color:#E8682A; }

/* ── Acessibilidade ── */
.sr-only {
    position:absolute; width:1px; height:1px; padding:0; margin:-1px;
    overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
}
:focus-visible { outline:3px solid #E8682A; outline-offset:3px; }

/* ── Corpo ── */
#per-lista { background:#f0f2f5; padding:40px 0 64px; }

/* ── Grid auto-responsivo ── */
.per-grid {
    display:grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap:18px;
}

/* ── Card ── */
.per-card {
    background:#fff;
    border-radius:12px;
    border:1px solid #e8e8e8;
    box-shadow:0 1px 3px rgba(0,0,0,0.06), 0 3px 10px rgba(0,0,0,0.05);
    display:flex; flex-direction:column;
    transition:box-shadow .2s, transform .18s;
    overflow:hidden;
}
.per-card:hover {
    box-shadow:0 4px 20px rgba(0,0,0,0.12);
    transform:translateY(-2px);
}
.per-card.oculto { display:none; }

/* Cabeçalho: miniatura + título + Qualis */
.per-card .card-head {
    display:flex; align-items:flex-start; gap:12px;
    padding:16px 18px 10px;
}
.per-card .card-thumb {
    width:48px; height:48px; flex-shrink:0;
    border-radius:8px; overflow:hidden;
    border:1px solid rgba(0,0,0,0.07);
    background:#f7f8fa;
    display:flex; align-items:center; justify-content:center;
}
.per-card .card-thumb img {
    width:100%; height:100%;
    object-fit:contain; padding:4px;
}
.per-card .card-thumb-letter {
    width:48px; height:48px; flex-shrink:0;
    border-radius:8px;
    background:var(--qcor, #aaa);
    display:flex; align-items:center; justify-content:center;
    font-size:1.25rem; font-weight:900; color:#fff;
}
.per-card .card-head-info { flex:1; min-width:0; }
.per-card .card-titulo-h { margin:0 0 3px; }
.per-card .card-titulo {
    font-size:.95rem; font-weight:800; color:#1a1a1a;
    text-decoration:none; line-height:1.3; display:block;
    transition:color .15s;
}
.per-card .card-titulo:hover { color:#E8682A; text-decoration:none; }
.per-card .card-subtitulo {
    font-size:.78rem; font-weight:400;
    color:#b0b0b0;
}
.qualis-chip {
    display:inline-flex; align-items:center; flex-shrink:0;
    border-radius:6px; padding:3px 9px; margin-top:2px;
    font-size:.68rem; font-weight:800; letter-spacing:.04em;
}

/* Corpo */
.per-card .card-body {
    padding:0 18px 16px;
    flex:1; display:flex; flex-direction:column;
}
.per-card .card-desc {
    font-size:.82rem; color:#555; line-height:1.62;
    flex:1; margin-bottom:14px;
}
.per-card .card-footer {
    display:flex; align-items:center; justify-content:space-between;
    gap:8px; padding-top:10px; margin-bottom:10px;
    border-top:1px solid #f0f0f0;
}
.card-issn { font-size:.72rem; color:#c8c8c8; }
.card-contact {
    font-size:.72rem; font-weight:600; color:#E8682A;
    text-decoration:none;
}
.card-contact:hover { text-decoration:underline; }

/* Botões touch-friendly (mín. 44px) */
.per-card .card-actions { display:flex; gap:8px; }
.per-card .card-actions a {
    display:flex; align-items:center; justify-content:center;
    flex:1; min-height:44px;
    border-radius:8px; font-size:.80rem; font-weight:600;
    text-decoration:none;
    transition:filter .15s, transform .1s;
}
.per-card .card-actions a:hover { filter:brightness(.87); transform:translateY(-1px); text-decoration:none; }
.per-card .card-actions a:focus-visible { outline:3px solid #E8682A; outline-offset:2px; }
.btn-acesso { background:#E8682A; color:#fff !important; }
.btn-edicao { background:#eef0f3; color:#444 !important; }

/* ── Sem resultados ── */
#sem-resultados { display:none; text-align:center; padding:60px 0; color:#888; }
#sem-resultados .icon { font-size:2.5rem; margin-bottom:12px; }

/* ── Nota Qualis ── */
.qualis-nota {
    font-size:.78rem; color:#aaa; text-align:center;
    margin-top:36px; padding-top:20px;
    border-top:1px solid #e4e4e4;
}
.qualis-nota a { color:#E8682A; text-decoration:none; }
.qualis-nota a:hover { text-decoration:underline; }

/* ── Responsivo ── */
@media(max-width:767px){
    #per-hero h1 { font-size:1.5rem; }
    .search-bar-wrap input { font-size:.95rem; }
    .qualis-filters {
        flex-wrap:nowrap; overflow-x:auto; justify-content:flex-start;
        padding-left:4px; padding-right:4px;
        -webkit-overflow-scrolling:touch; scrollbar-width:none;
    }
    .qualis-filters::-webkit-scrollbar { display:none; }
    .qf-btn { flex-shrink:0; }
    .per-stats { gap:20px; }
}
</style>

<!-- Hero -->
<section id="per-hero">
    <div class="container hero-content">
        <h1>Periódicos Correntes</h1>
        <p>Acesse as revistas científicas ativas publicadas e apoiadas pelo Portal de Periódicos da UFPB.</p>

        <div role="search" class="search-bar-wrap">
            <label for="buscaInput" class="sr-only">Pesquisar periódico por título, subtítulo ou ISSN</label>
            <input type="search" id="buscaInput"
                   placeholder="Pesquise por título, subtítulo ou ISSN…"
                   oninput="filtrar()"
                   autocomplete="off"
                   aria-label="Pesquisar periódico por título, subtítulo ou ISSN">
            <span class="search-icon" aria-hidden="true">🔍</span>
        </div>

        <div class="qualis-filters" role="group" aria-label="Filtrar por nível Qualis">
            <button class="qf-btn todos ativo" onclick="filtrarQualis('todos',this)"
                    aria-pressed="true">Todos</button>
            <?php
            $niveis = ['A1','A2','A3','A4','B1','B2','B3','B4','C','NC'];
            foreach($niveis as $n):
                $c = qualisCor($n);
            ?>
            <button class="qf-btn" style="background:<?=$c['bg']?>;color:<?=$c['txt']?>;"
                    onclick="filtrarQualis('<?=$n?>',this)"
                    aria-pressed="false"><?=$n?></button>
            <?php endforeach; ?>
        </div>

        <div class="per-stats">
            <div><div class="num"><?=$totalRevistas?></div><div class="lab">Periódicos ativos</div></div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%;height:48px;display:block;">
            <path d="M0,32 C360,0 1080,60 1440,20 L1440,48 L0,48 Z" fill="#eef0f3"/>
        </svg>
    </div>
</section>

<!-- Lista -->
<section id="per-lista">
<div class="container">

<div class="per-grid" id="per-grid">
<?php foreach($periodicos as $p):
    $c      = qualisCor($p['qualis']);
    $tPlain = html_entity_decode(strip_tags($p['titulo']), ENT_QUOTES, 'UTF-8');
    $sPlain = html_entity_decode(strip_tags($p['subtitulo'] ?? ''), ENT_QUOTES, 'UTF-8');
    $letra  = mb_strtoupper(mb_substr($tPlain, 0, 1, 'UTF-8'), 'UTF-8');
    $hasImg = !empty($p['img']);
?>
<article class="per-card"
     style="--qcor:<?=$c['bg']?>;"
     data-titulo="<?=htmlspecialchars(mb_strtolower($tPlain,'UTF-8'))?>"
     data-subtitulo="<?=htmlspecialchars(mb_strtolower($sPlain,'UTF-8'))?>"
     data-issn="<?=$p['issn']?>"
     data-qualis="<?=$p['qualis']?>">

    <!-- Cabeçalho: miniatura + título + Qualis -->
    <div class="card-head">
        <?php if($hasImg): ?>
        <div class="card-thumb">
            <img src="<?=$p['img']?>" alt="Logo <?=htmlspecialchars($tPlain)?>"
                 onerror="this.closest('.card-thumb').outerHTML='<div class=\'card-thumb-letter\'><?=$letra?></div>'">
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

        <span class="qualis-chip"
              style="background:<?=$c['bg']?>;color:<?=$c['txt']?>"
              aria-label="Qualis <?=$p['qualis']?>"><?=$p['qualis']?></span>
    </div>

    <!-- Corpo -->
    <div class="card-body">
        <p class="card-desc"><?=$p['desc']?></p>
        <div class="card-footer">
            <span class="card-issn">ISSN <?=$p['issn']?></span>
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
</div><!-- /.per-grid -->

<div id="sem-resultados" role="status" aria-live="polite" aria-atomic="true">
    <div class="icon">🔍</div>
    <p>Nenhum periódico encontrado para esta busca.</p>
</div>

<p class="qualis-nota">
    * As classificações Qualis indicadas referem-se às notas disponibilizadas pela
    <a href="https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/veiculoPublicacaoQualis/listaConsultaGeralPeriodicos.jsf" target="_blank" rel="noopener">Plataforma Sucupira/CAPES</a>
    para o quadriênio 2021–2024.
    Periódicos identificados como <strong>NC</strong> (Não Classificado) ainda não possuem classificação disponível na Plataforma Sucupira/CAPES para o referido quadriênio.
</p>

</div>
</section>

<script>
function removerAcentos(s){ return s.normalize('NFD').replace(/[̀-ͯ]/g,'').toLowerCase(); }

var qualisAtivo = 'todos';

function filtrar(){
    var qRaw = document.getElementById('buscaInput').value.trim();
    var q = removerAcentos(qRaw);
    var termos = q.split(/\s+/).filter(Boolean);
    var issnTerm = q.replace(/-/g,'');
    var total = 0;

    document.querySelectorAll('.per-card').forEach(function(card){
        var titulo    = removerAcentos(card.dataset.titulo||'');
        var subtitulo = removerAcentos(card.dataset.subtitulo||'');
        var texto     = (titulo + ' ' + subtitulo).trim();
        var issn      = (card.dataset.issn||'').replace(/-/g,'');

        // ISSN: compara dígitos, ignorando hífen
        var matchIssn = issnTerm.length>0 && issn.indexOf(issnTerm)>=0;

        // Título/Subtítulo: cada termo digitado deve aparecer em algum lugar do texto
        var matchTexto = termos.length>0 && termos.every(function(t){ return texto.indexOf(t)>=0; });

        var matchBusca  = !q || matchTexto || matchIssn;
        var matchQualis = qualisAtivo==='todos' || card.dataset.qualis===qualisAtivo;
        var show = matchBusca && matchQualis;
        card.classList.toggle('oculto', !show);
        if(show) total++;
    });
    document.getElementById('sem-resultados').style.display = total===0 ? 'block' : 'none';
}

function filtrarQualis(nivel, btn){
    document.querySelectorAll('.qf-btn').forEach(function(b){
        b.classList.remove('ativo');
        b.setAttribute('aria-pressed','false');
    });
    btn.classList.add('ativo');
    btn.setAttribute('aria-pressed','true');
    qualisAtivo = nivel;
    filtrar();
}
</script>

<?php include 'footer.html'; ?>
