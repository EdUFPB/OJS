<?php include 'header.html'; ?>

<?php
$periodicos = [
    // A1
    ['titulo'=>'Moringa',                  'subtitulo'=>'Artes do Espetáculo',
     'caminho'=>'moringa',     'qualis'=>'A1', 'issn'=>'2177-8841',
     'area'=>'Artes Cênicas', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/moringa.png',
     'desc'=>'Diálogo interdisciplinar nas artes cênicas — criação, poéticas espetaculares e relações com a cultura.'],

    ['titulo'=>'Problemata',               'subtitulo'=>'Revista Internacional de Filosofia',
     'caminho'=>'problemata',  'qualis'=>'A1', 'issn'=>'2236-8612',
     'area'=>'Filosofia', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/problemata.png',
     'desc'=>'Publica artigos, traduções e resenhas filosóficas em português, francês, espanhol, italiano e alemão.'],

    // A2
    ['titulo'=>'Aufklärung',               'subtitulo'=>'Journal of Philosophy',
     'caminho'=>'arf',         'qualis'=>'A2', 'issn'=>'2318-9428',
     'area'=>'Filosofia', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/auk.png',
     'desc'=>'Espaço aberto ao debate filosófico entre pesquisadores do Brasil e do exterior, com ênfase em ética e epistemologia.'],

    ['titulo'=>'Informação &amp; Sociedade', 'subtitulo'=>'Estudos',
     'caminho'=>'ies',         'qualis'=>'A2', 'issn'=>'1809-4783',
     'area'=>'Ciência da Informação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/informacao_e_sociedade.png',
     'desc'=>'Uma das primeiras revistas brasileiras de Ciência da Informação indexada no Journal Citation Reports (JCR), publicada desde 1991.'],

    ['titulo'=>'Okara',                    'subtitulo'=>'Geografia em Debate',
     'caminho'=>'okara',       'qualis'=>'A2', 'issn'=>'1982-3878',
     'area'=>'Geografia', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/okara.png',
     'desc'=>'Fomenta o debate geográfico entre pesquisadores, docentes e profissionais, com foco em teoria e prática da Geografia.'],

    ['titulo'=>'Revista Ártemis',          'subtitulo'=>'Gênero, Feminismos e Sexualidades',
     'caminho'=>'artemis',     'qualis'=>'A2', 'issn'=>'1807-8214',
     'area'=>'Estudos de Gênero', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/artemis.png',
     'desc'=>'Produção científica interdisciplinar sobre gênero, feminismos e sexualidades sob perspectivas históricas, literárias e culturais.'],

    ['titulo'=>'Sæculum',                  'subtitulo'=>'Revista de História',
     'caminho'=>'srh',         'qualis'=>'A2', 'issn'=>'2317-6725',
     'area'=>'História', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/saeculum2.png',
     'desc'=>'Publicação do PPGH/UFPB voltada para pesquisas em História, Cultura Histórica e interfaces com outras áreas.'],

    // A3
    ['titulo'=>'Claves',                   'subtitulo'=>'Música e Pesquisa',
     'caminho'=>'claves',      'qualis'=>'A3', 'issn'=>'1983-3709',
     'area'=>'Música', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/claves.png',
     'desc'=>'Periódico do PPGM/UFPB dedicado à Composição, Educação Musical, Musicologia e Práticas Interpretativas.'],

    ['titulo'=>'Política &amp; Trabalho',  'subtitulo'=>'Revista de Ciências Sociais',
     'caminho'=>'politicaetrabalho', 'qualis'=>'A3', 'issn'=>'1517-5901',
     'area'=>'Ciências Sociais', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/politicaetrabalho2.png',
     'desc'=>'Publicação do PPGS/UFPB com mais de 30 anos de debate qualificado em Sociologia, Política e Antropologia.'],

    ['titulo'=>'Espaço do Currículo',      'subtitulo'=>'GEPPC – UFPB',
     'caminho'=>'rec',         'qualis'=>'A3', 'issn'=>'1983-1579',
     'area'=>'Educação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/revista-espaco-do-curriculo.png',
     'desc'=>'Periódico do GEPPC/UFPB, criado em 2008, dedicado ao debate nacional e internacional sobre políticas e estudos curriculares na Educação.'],

    ['titulo'=>'Temas em Educação',        'subtitulo'=>'PPGE – UFPB',
     'caminho'=>'rteo',        'qualis'=>'A3', 'issn'=>'0104-2777',
     'area'=>'Educação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/rte.png',
     'desc'=>'Fundada em 1991 e online desde 2009, é organizada pelo PPGE/UFPB prioriza pesquisas científicas nacionais e internacionais em Educação.'],

    ['titulo'=>'Âncora',                   'subtitulo'=>'Revista de Jornalismo',
     'caminho'=>'ancora',      'qualis'=>'A3', 'issn'=>'2359-375X',
     'area'=>'Comunicação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/ancora.png',
     'desc'=>'Voltada para a pesquisa em Jornalismo na perspectiva latino-americana, com diálogos entre comunicação e cultura.'],

    // A4
    ['titulo'=>'Biblionline',              'subtitulo'=>'DCI – UFPB',
     'caminho'=>'biblio',      'qualis'=>'A4', 'issn'=>'1809-4775',
     'area'=>'Ciência da Informação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/biblionline.png',
     'desc'=>'Publicada ininterruptamente desde 2005 nas áreas de Biblioteconomia, Arquivologia, Ciência da Informação e Museologia com acesso aberto e avaliação por pares.'],

    ['titulo'=>'Prolíngua',               'subtitulo'=>'Linguística – UFPB',
     'caminho'=>'prolingua',   'qualis'=>'A4', 'issn'=>'1983-9979',
     'area'=>'Linguística', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/prolingua.png',
     'desc'=>'Espaço consolidado de divulgação de pesquisas teóricas e aplicadas em Linguística, promovendo o debate entre pesquisadores nacionais e internacionais.'],

    ['titulo'=>'Revista Brasileira de Políticas Públicas e Internacionais',                     'subtitulo'=>'RPPI',
     'caminho'=>'rppi',        'qualis'=>'A4', 'issn'=>'2525-5584',
     'area'=>'Relações Internacionais', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/rppi.png',
     'desc'=>'A Revista Brasileira de Políticas Públicas e Internacionais aborda Gestão Pública e Políticas Públicas nos planos doméstico e internacional.'],

    ['titulo'=>'RECFin',                   'subtitulo'=>'Evidenciação Contábil &amp; Finanças',
     'caminho'=>'recfin',      'qualis'=>'A4', 'issn'=>'2318-1001',
     'area'=>'Contabilidade', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/recfin.png',
     'desc'=>'Reúne estudos voltados à Contabilidade, Atuária e Finanças, abordando temas relacionados à gestão, mercados, educação e inovação, com foco na produção e disseminação do conhecimento científico.'],

    ['titulo'=>'Scandia',                  'subtitulo'=>'Journal of Medieval Norse Studies',
     'caminho'=>'scandia',     'qualis'=>'A4', 'issn'=>'2595-9107',
     'area'=>'História', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/scandia.png',
     'desc'=>'Especializada em Estudos Nórdicos Medievais, publica pesquisas sobre a Era Viking e o mundo escandinavo, contemplando abordagens em história, mitologia, religião, literatura e arqueologia.'],

    ['titulo'=>'Teoria e Prática em Administração', 'subtitulo'=>'PPGA – UFPB',
     'caminho'=>'tpa',         'qualis'=>'A4', 'issn'=>'2238-104X',
     'area'=>'Administração', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/tpa.png',
     'desc'=>'Periódico do PPGA/UFPB voltado a executivos, gestores públicos, empreendedores e docentes — dissemina conhecimentos que conectam teoria e prática da Administração.'],

    ['titulo'=>'Áltera',                   'subtitulo'=>'Revista de Antropologia',
     'caminho'=>'altera',      'qualis'=>'A4', 'issn'=>'2447-9837',
     'area'=>'Antropologia', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/altera.png',
     'desc'=>'Espaço dedicado ao debate antropológico contemporâneo, acolhendo diferentes perspectivas teóricas, metodológicas e etnográficas sobre fenômenos sociais, culturais e políticos.'],

    // B1
    ['titulo'=>'Archeion Online',          'subtitulo'=>'Arquivologia – UFPB',
     'caminho'=>'archeion',    'qualis'=>'B1', 'issn'=>'2318-6186',
     'area'=>'Arquivologia', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/archeion.png',
     'desc'=>'Periódico semestral vinculado ao curso de Arquivologia da UFPB — publica artigos originais sobre temas relevantes da Arquivologia e áreas afins, cumprindo a missão de produzir e divulgar conhecimento.'],

    ['titulo'=>'Culturas Midiáticas',      'subtitulo'=>'PPGC – UFPB',
     'caminho'=>'cm',          'qualis'=>'B1', 'issn'=>'1983-5930',
     'area'=>'Comunicação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/culturas-midiaticas.png',
     'desc'=>'Lançada em 2008, publica pesquisas em Comunicação e suas interfaces com culturas audiovisuais, midiatização do cotidiano e do imaginário — incentivando a transdisciplinaridade.'],

    ['titulo'=>'Journal Urban &amp; Environmental Engineering',                     'subtitulo'=>'JUEE',
     'caminho'=>'juee',        'qualis'=>'B1', 'issn'=>'1982-3932',
     'area'=>'Engenharia', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/juee1.png',
     'desc'=>'Focada nos desafios das cidades e do meio ambiente, publica pesquisas sobre recursos hídricos, saneamento, transporte, planejamento urbano e sustentabilidade ambiental.'],

    ['titulo'=>'Letr@ Viv@',              'subtitulo'=>'DLEM – UFPB',
     'caminho'=>'lv',          'qualis'=>'B1', 'issn'=>'1517-3100',
     'area'=>'Letras', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/lv.jpg',
     'desc'=>'Periódico do DLEM/UFPB publicado desde 1999, com edição semestral em fluxo contínuo nas áreas de Literatura, Linguística, Tradução, Ensino de Línguas e Formação de Professores.'],

    ['titulo'=>'Perspectivas em Gestão & Conhecimento',               'subtitulo'=>'PG&amp;C',
     'caminho'=>'pgc',         'qualis'=>'B1', 'issn'=>'2236-417X',
     'area'=>'Ciência da Informação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/pgec.png',
     'desc'=>'A Revista Perspectivas em Gestão e Conhecimento é iniciativa da UFPB em cooperação com o IBICT, publica pesquisas interdisciplinares em gestão do conhecimento, gestão da informação e estudos organizacionais.'],

    ['titulo'=>'Prim Facie',              'subtitulo'=>'Estudos Jurídicos Contemporâneos',
     'caminho'=>'primafacie',  'qualis'=>'B1', 'issn'=>'1678-2593',
     'area'=>'Direito', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/prima-facie.png',
     'desc'=>'Dedicado à divulgação de pesquisas inovadoras e ao debate de temas contemporâneos do Direito. Destaca-se pela abordagem interdisciplinar de questões relacionadas aos direitos humanos, desenvolvimento, meio ambiente e justiça social.'],

    ['titulo'=>'Revista Educare',         'subtitulo'=>'DFE/CE – UFPB',
     'caminho'=>'educare',     'qualis'=>'B1', 'issn'=>'2527-1083',
     'area'=>'Educação', 'situacao'=>'Correntes', 'periodicidade'=>'Anual',
     'img'=>'images/educare.jpg',
     'desc'=>'Iniciativa do DFE/CE/UFPB, publica anualmente trabalhos inéditos nos Fundamentos da Educação em português, espanhol, inglês e outros idiomas, de pesquisadores e pós-graduandos.'],

    ['titulo'=>'Temática',                'subtitulo'=>'NAMID/DEMID – UFPB',
     'caminho'=>'tematica',    'qualis'=>'B1', 'issn'=>'1807-8931',
     'area'=>'Comunicação', 'situacao'=>'Correntes', 'periodicidade'=>'Mensal',
     'img'=>'images/tematica.jpg',
     'desc'=>'Fundada em 2004, é uma publicação mensal interdisciplinar em Comunicação e áreas afins, integrada ao NAMID/UFPB, com fluxo contínuo aberto a pesquisadores da graduação e pós-graduação.'],

    // B2
    ['titulo'=>'Religare',                'subtitulo'=>'Ciências das Religiões',
     'caminho'=>'religare',    'qualis'=>'B2', 'issn'=>'1982-6605',
     'area'=>'Ciência da Religião', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/religare.png',
     'desc'=>'Periódico do PPGCR/UFPB que publica artigos, resenhas e traduções em Ciências das Religiões e áreas afins.'],

    ['titulo'=>'Revista da ABET',         'subtitulo'=>'Estudos do Trabalho',
     'caminho'=>'abet',        'qualis'=>'B2', 'issn'=>'1679-2483',
     'area'=>'Ciências Sociais', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/abet.png',
     'desc'=>'A Revista da Associação Brasileira de Estudos do Trabalho foi lançada em 2001, reúne pesquisas interdisciplinares sobre o mundo do trabalho — Economia, Sociologia, Direito, História, Saúde e outras áreas.'],

    ['titulo'=>'Revista da Iniciação Científica em Relações Internacionais',                   'subtitulo'=>'RICRI',
     'caminho'=>'ricri',       'qualis'=>'B2', 'issn'=>'2318-9452',
     'area'=>'Relações Internacionais', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/ricri.jpg',
     'desc'=>'Revista da Iniciação científica em Relações Internacionais — incentiva jovens pesquisadores no debate global e diplomático.'],

    // B3
    ['titulo'=>'Cadernos do LOGEPA',      'subtitulo'=>'LOGEPA/GENAT – UFPB',
     'caminho'=>'logepa',      'qualis'=>'B3', 'issn'=>'2237-7522',
     'area'=>'Geografia', 'situacao'=>'Correntes', 'periodicidade'=>'Anual',
     'img'=>'images/cadernos-logepa.png',
     'desc'=>'Vinculada ao LOGEPA/UFPB, publica pesquisas em Geografia, Geomorfologia, gestão de riscos naturais e dinâmicas socioambientais da Paraíba, com volume anual em fluxo contínuo.'],

    ['titulo'=>'CAOS',                    'subtitulo'=>'Ciências Sociais',
     'caminho'=>'caos',        'qualis'=>'B3', 'issn'=>'1517-6916',
     'area'=>'Ciências Sociais', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/caos.png',
     'desc'=>'A Revista Eletrônica de Ciências Sociais é um espaço de diálogo e reflexão nas áreas de Antropologia, Ciência Política e Sociologia, reunindo pesquisas, ensaios e debates sobre questões contemporâneas da sociedade.'],

    ['titulo'=>'DLCV',                    'subtitulo'=>'Língua, Linguística &amp; Literatura',
     'caminho'=>'dclv',        'qualis'=>'B3', 'issn'=>'2237-0900',
     'area'=>'Letras', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/dlcv.png',
     'desc'=>'Um espaço para a divulgação e o debate de pesquisas sobre linguagem, literatura e culturas. Publica estudos, ensaios, traduções e resenhas que ampliam as reflexões sobre os múltiplos aspectos das línguas e das práticas literárias.'],

    ['titulo'=>'Gaia Scientia',           'subtitulo'=>'PRODEMA – UFPB',
     'caminho'=>'gaia',        'qualis'=>'B3', 'issn'=>'1981-1268',
     'area'=>'Ciências Ambientais', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/gaia.png',
     'desc'=>'Lançada em 2007 pelo PRODEMA/UFPB, publica artigos originais em Ciências Ambientais e suas interfaces com Ecologia, Etnobiologia, Geografia Ambiental, Saúde e Engenharia Ambiental.'],

    ['titulo'=>'Revista Brasileira de Ciências da Saúde',                    'subtitulo'=>'RBCS',
     'caminho'=>'rbcs',        'qualis'=>'B3', 'issn'=>'2317-6032',
     'area'=>'Ciências da Saúde', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/rbcs.png',
     'desc'=>'Produção acadêmica em Ciências da Saúde com foco na realidade brasileira e na qualidade da assistência.'],

    ['titulo'=>'Revista Graphos',         'subtitulo'=>'PPGL – UFPB',
     'caminho'=>'graphos',     'qualis'=>'B3', 'issn'=>'2763-9355',
     'area'=>'Letras', 'situacao'=>'Correntes', 'periodicidade'=>'Quadrimestral',
     'img'=>'images/graphos.png',
     'desc'=>'Publicada pelo PPGL/UFPB desde 1995, divulga artigos inéditos de pesquisadores brasileiros e estrangeiros nas áreas de Literatura, Cultura, Teoria Literária e Tradução, com periodicidade quadrimestral.'],

    // B4
    ['titulo'=>'Revista Agropecuária Técnica',    'subtitulo'=>'AGROTEC',
     'caminho'=>'at',          'qualis'=>'B4', 'issn'=>'2525-8990',
     'area'=>'Ciências Agrárias', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/at.jpg',
     'desc'=>'Editada pelo CCA/UFPB em fluxo contínuo, publica artigos originais nas Ciências Agrárias — Agronomia, Medicina Veterinária, Zootecnia, Ciências Florestais, Engenharia Agrícola e áreas afins.'],

    ['titulo'=>'Gestão &amp; Aprendizagem', 'subtitulo'=>'PPGOA – UFPB',
     'caminho'=>'mpgoa',       'qualis'=>'B4', 'issn'=>'2526-3102',
     'area'=>'Administração', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/mpgoa.jpg',
     'desc'=>'Periódico do PPGOA/UFPB publicado desde 2012, focado nos estudos dos processos de gestão e aprendizagem organizacionais.'],

    ['titulo'=>'Letras et Ideias',        'subtitulo'=>'PPGL/CCHLA – UFPB',
     'caminho'=>'letraseideias','qualis'=>'B4', 'issn'=>'2595-7295',
     'area'=>'Letras', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/letraseideias.jpg',
     'desc'=>'Revista eletrônica de acesso livre do PPGL/CCHLA/UFPB, publica trabalhos inéditos em Letras, Linguística, Literatura e áreas afins.'],

    ['titulo'=>'Prosppectus',             'subtitulo'=>'Metodologias Qualitativas',
     'caminho'=>'prosp',       'qualis'=>'B4', 'issn'=>'2763-9606',
     'area'=>'Contabilidade', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/prospectus.jpg',
     'desc'=>'Primeiro periódico nacional dedicado a metodologias qualitativas em Contabilidade — vinculado ao DFC/UFPB, com publicação semestral de artigos teórico-empíricos e ensaios teóricos.'],

    ['titulo'=>'Revista Abordagens',      'subtitulo'=>'PPGS – UFPB',
     'caminho'=>'rappgs',      'qualis'=>'B4', 'issn'=>'2674-824X',
     'area'=>'Sociologia', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/rappgs.jpg',
     'desc'=>'Publicação semestral do corpo discente do PPGS/UFPB, com linha editorial plural voltada ao campo sociológico e áreas afins.'],

    ['titulo'=>'Revista Científica de Produção Animal', 'subtitulo'=>'Produção Animal',
     'caminho'=>'rcpa',        'qualis'=>'B4', 'issn'=>'2176-4158',
     'area'=>'Ciências Agrárias', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/rcpa.jpg',
     'desc'=>'Vinculado ao CCA/UFPB e a Sociedade Nordestina de Produção Animal desde 1999, publica trabalhos inéditos em Zootecnia — Nutrição Animal, Forragicultura, Genômica, Reprodução e Sistemas de Produção.'],

    ['titulo'=>'LiteralMENTE',            'subtitulo'=>'LIGEPSI – UFPB',
     'caminho'=>'rl',          'qualis'=>'B4', 'issn'=>'2764-4251',
     'area'=>'Letras', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/rl.jpg',
     'desc'=>'Periódico semestral do LIGEPSI/UFPB dedicado aos estudos literários e suas interfaces com a Psicanálise — publica artigos, ensaios, resenhas e relatos em fluxo contínuo.'],

    ['titulo'=>'Ratio Iuris',             'subtitulo'=>'CCJ – UFPB',
     'caminho'=>'rri',         'qualis'=>'B4', 'issn'=>'2358-4351',
     'area'=>'Direito', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/rri.jpg',
     'desc'=>'Periódico semestral do CCJ/UFPB voltado a incentivar a produção científica na graduação e divulgar a produção intelectual em Direito.'],

    ['titulo'=>'Sanhauá',                 'subtitulo'=>'Revista de Extensão da UFPB',
     'caminho'=>'snh',         'qualis'=>'B4', 'issn'=>'2966-1005',
     'area'=>'Extensão Universitária', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/sanhaua.png',
     'desc'=>'Publicação da PROEX/UFPB que valoriza e divulga as ações de extensão universitária em fluxo contínuo.'],

    // C
    ['titulo'=>'Comunicações em Informática', 'subtitulo'=>'DI – UFPB',
     'caminho'=>'cei',         'qualis'=>'C',  'issn'=>'2595-0622',
     'area'=>'Ciência da Computação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/cei.jpg',
     'desc'=>'Periódico do Departamento de Informática/UFPB que divulga relatos científicos em Ciência da Computação e suas interfaces com Saúde, Educação, Engenharias e outras áreas.'],

    ['titulo'=>'Direitos Humanos e Transdisciplinaridade',                     'subtitulo'=>'DHT',
     'caminho'=>'dht',         'qualis'=>'C',  'issn'=>'2965-4432',
     'area'=>'Direito', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/dht.jpg',
     'desc'=>'A Revista Direitos Humanos e Transdisciplinaridade aborda os direitos humanos sob perspectiva transdisciplinar, integrando Direito, Filosofia e Ciências Sociais.'],

    ['titulo'=>'Caderno de Docências',    'subtitulo'=>'Educação e Ensino',
     'caminho'=>'cad',         'qualis'=>'C',  'issn'=>'2764-7153',
     'area'=>'Educação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/cad.jpg',
     'desc'=>'Periódico de acesso aberto da UFPB dedicado a pesquisas, ensaios e experiências sobre práticas docentes e processos educativos em suas dimensões pedagógicas, éticas e políticas.'],

    ['titulo'=>'Revista de Iniciação Científica em Odontologia',                  'subtitulo'=>'RevICO',
     'caminho'=>'revico',      'qualis'=>'C',  'issn'=>'1677-3527',
     'area'=>'Odontologia', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/revico.png',
     'desc'=>'Incentiva a pesquisa científica em Odontologia, dando voz à produção de graduandos e pós-graduandos.'],

    ['titulo'=>'Revista InterCulturas',   'subtitulo'=>'MINNI Mundo – UFPB/CNPq',
     'caminho'=>'rics',        'qualis'=>'C',  'issn'=>'2966-3997',
     'area'=>'Relações Internacionais', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/rics.jpg',
     'desc'=>'Periódico semestral do grupo MINNI Mundo/UFPB dedicado a mediações interculturais, diplomacia, relações internacionais e processos de negociação em contextos globais.'],

    ['titulo'=>'Revista Medicina &amp; Pesquisa', 'subtitulo'=>'Ciências da Saúde',
     'caminho'=>'rmp',         'qualis'=>'C',  'issn'=>'2525-5851',
     'area'=>'Ciências da Saúde', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/rmp.jpg',
     'desc'=>'Periódico interdisciplinar em Ciências da Saúde da UFPB — publica estudos originais, revisões e produções acadêmicas sobre cuidado, prática clínica, educação e sistemas de saúde.'],

    // NC — Não Classificado
    ['titulo'=>'Benjaminiana',           'subtitulo'=>'Estudos em Tradução e Imagem',
     'caminho'=>'breti',       'qualis'=>'NC', 'issn'=>'3086-2396',
     'area'=>'Letras', 'situacao'=>'Correntes', 'periodicidade'=>'Trimestral',
     'img'=>'images/breti.jpg',
     'desc'=>'Publicação trimestral especializada em Estudos da Tradução e Imagem, com ênfase na obra de Walter Benjamin e interfaces com Literatura, Semiótica e História da Arte.'],

    ['titulo'=>'Fala Tu!',               'subtitulo'=>'Pedagogia UFPB',
     'caminho'=>'ftu',         'qualis'=>'NC', 'issn'=>'3086-111X',
     'area'=>'Educação', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/ftu.jpg',
     'desc'=>'Periódico semestral que socializa a produção acadêmica e literária de graduandos em Pedagogia/CE/UFPB, com espaço plural para diferentes vozes e formas de linguagem.'],

    ['titulo'=>'Revista Discurso &amp; Imagem Visual em Educação', 'subtitulo'=>'RDIVE – GEPDIVE/UFPB',
     'caminho'=>'rdive',       'qualis'=>'NC', 'issn'=>'2526-0839',
     'area'=>'Educação', 'situacao'=>'Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/rdive.jpg',
     'desc'=>'Publica pesquisas sobre nexos pedagógicos entre discurso, imagem visual e educação, a partir das artes, filosofia, letras e ciências humanas.'],

    ['titulo'=>'Revista Lugares de Educação', 'subtitulo'=>'Educação - CCHSA/UFPB',
     'caminho'=>'rle',         'qualis'=>'NC', 'issn'=>'2237-1451',
     'area'=>'Educação', 'situacao'=>'Correntes', 'periodicidade'=>'Anual',
     'img'=>'images/rle.jpg',
     'desc'=>'Publicação anual do Departamento de Educação do CCHSA/UFPB, em fluxo contínuo, voltada para estudos e pesquisas em Educação.'],

    ['titulo'=>'Textos NDIHR',           'subtitulo'=>'Memória e História',
     'caminho'=>'ndihr',       'qualis'=>'NC', 'issn'=>'',
     'area'=>'História', 'situacao'=>'Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/ndihr.jpg',
     'desc'=>'Publicação semestral do NDIHR/UFPB, criada em 1985, dedicada à divulgação de estudos e pesquisas nas Humanidades produzidos por professores, alunos e técnicos.'],

    // ── Anais de Eventos ──
    ['titulo'=>'Cadernos Imbondeiro',      'subtitulo'=>'Estudos Africanos e Afro-brasileiros – UFPB',
     'caminho'=>'ci',          'qualis'=>'', 'issn'=>'2316-2937',
     'area'=>'Estudos Africanos e Afro-brasileiros', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/cadernos-imbondeiro.png',
     'desc'=>'Apresenta estudos africanos, afro-brasileiros e da diáspora africana, articulando pesquisa sobre cultura, história e identidade.'],

    ['titulo'=>'Cultura e Tradução',       'subtitulo'=>'Estudos da Tradução – UFPB',
     'caminho'=>'ct',          'qualis'=>'', 'issn'=>'2238-9059',
     'area'=>'Letras', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/cultura-traducao.png',
     'desc'=>'Aborda estudos da Tradução e suas interfaces com a Cultura, a Linguística e a Literatura, com publicações de artigos originais e inéditos.'],

    ['titulo'=>'Congresso de Inclusão e Acessibilidade', 'subtitulo'=>'Anais – UFPB',
     'caminho'=>'cia',         'qualis'=>'', 'issn'=>'',
     'area'=>'Educação', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/cia.jpg',
     'desc'=>'Anais de congresso dedicado à produção e disseminação de conhecimentos sobre inclusão, acessibilidade e diversidade no contexto educacional e social.'],

    ['titulo'=>'Anais do Colóquio de Cinema e Arte da América Latina', 'subtitulo'=>'COCAAL – UFPB',
     'caminho'=>'cocaal',      'qualis'=>'', 'issn'=>'',
     'area'=>'Artes', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/cocaal.jpg',
     'desc'=>'Publicação dos trabalhos apresentados no colóquio voltados ao cinema e às artes visuais na América Latina, com ênfase em perspectivas críticas e decoloniais.'],

    ['titulo'=>'Revista do Encontro de Iniciação à Docência', 'subtitulo'=>'ENID – UFPB',
     'caminho'=>'enid',        'qualis'=>'', 'issn'=>'',
     'area'=>'Educação', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'',
     'desc'=>'Publicação do Encontro de Iniciação à Docência da UFPB, divulga pesquisas e experiências em formação de professores e práticas pedagógicas.'],

    ['titulo'=>'Revista de Iniciação Científica', 'subtitulo'=>'PROPESQ - UFPB',
     'caminho'=>'enic',        'qualis'=>'', 'issn'=>'',
     'area'=>'Multidisciplinar', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'',
     'desc'=>'Publicação do Encontro de Iniciação à Científica da Pro-Reitoria de Pesquisa da UFPB.'],

    ['titulo'=>'Anais do Encontro de Extensão da UFPB', 'subtitulo'=>'PROEX – UFPB',
     'caminho'=>'extensao',    'qualis'=>'', 'issn'=>'',
     'area'=>'Extensão Universitária', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'',
     'desc'=>'Publicação do Encontro de Extensão da UFPB.'],

    ['titulo'=>'Encontro Unificado da UFPB: anais do ENEX', 'subtitulo'=>'PROEX – UFPB',
     'caminho'=>'enex',        'qualis'=>'', 'issn'=>'',
     'area'=>'Extensão Universitária', 'situacao'=>'Anais de Eventos', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'',
     'desc'=>'Publicação do Encontro Unificado da UFPB, anais do ENEX.'],

    // ── Incubados ──
    ['titulo'=>'Perg@minho',               'subtitulo'=>'Revista Discente de História – UFPB',
     'caminho'=>'perg',        'qualis'=>'', 'issn'=>'3086-2299',
     'area'=>'História', 'situacao'=>'Incubados', 'periodicidade'=>'Semestral',
     'img'=>'images/pergaminho.jpg',
     'desc'=>'Editada semestralmente pelo Curso de História e PPGH da UFPB, aceita submissões de alunos de graduação e pós-graduação em História e áreas conexas das Ciências Humanas.'],

    ['titulo'=>'Sudamerica',               'subtitulo'=>'Revista Internacional de Direitos Humanos',
     'caminho'=>'sda',         'qualis'=>'', 'issn'=>'3086-3562',
     'area'=>'Direito', 'situacao'=>'Incubados', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/sudamerica.jpg',
     'desc'=>'Periódico internacional dedicado à pesquisa e debate em Direitos Humanos, com enfoque nos contextos e perspectivas da América do Sul.'],

    ['titulo'=>'Ostium Solis',             'subtitulo'=>'Revista de Filosofia',
     'caminho'=>'ros',         'qualis'=>'', 'issn'=>'',
     'area'=>'Filosofia', 'situacao'=>'Incubados', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/ostiumSolis.jpg',
     'desc'=>'A Revista Ostium Solis publica trabalhos de filosofia elaborados por graduandos, graduados, mestrandos, mestres, doutorandos e doutores, sem distinções.'],

    // ── Não Correntes ──
    ['titulo'=>'Acta Semiótica et Lingvistica', 'subtitulo'=>'Programa de Pós-Graduação em Letras – UFPB',
     'caminho'=>'actas',       'qualis'=>'', 'issn'=>'0102-4264',
     'area'=>'Linguística', 'situacao'=>'Não Correntes', 'periodicidade'=>'Quadrimestral',
     'img'=>'images/acta.png',
     'desc'=>'Periódico científico internacional, quadrimestral, dedicado ao intercâmbio entre pesquisadores de Semiótica e Linguística, Literatura Popular, Libras e Braile.'],

    ['titulo'=>'Pesquisa Brasileira em Ciência da Informação e Biblioteconomia', 'subtitulo'=>'PBCIB',
     'caminho'=>'pbcib',       'qualis'=>'', 'issn'=>'1981-0695',
     'area'=>'Ciência da Informação', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/pbcib.png',
     'desc'=>'Editada pelo Grupo de Pesquisa Informação e Inclusão Social (CNPq) em parceria com o Laboratório de Tecnologias Intelectuais da UFPB.'],

    ['titulo'=>'Revista Nordestina de Biologia', 'subtitulo'=>'Departamento de Sistemática e Ecologia – UFPB',
     'caminho'=>'revnebio',    'qualis'=>'', 'issn'=>'2236-1480',
     'area'=>'Biologia', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/nordestina-bio.png',
     'desc'=>'Publicação científica dedicada à Biologia, com ênfase em estudos realizados na região Nordeste do Brasil.'],

    ['titulo'=>'The Brazilian Trombone Association Journal', 'subtitulo'=>'Associação Brasileira de Trombone',
     'caminho'=>'btaj',        'qualis'=>'', 'issn'=>'2595-1238',
     'area'=>'Música', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/trombone.jpg',
     'desc'=>'Periódico da Associação Brasileira de Trombone, voltado à pesquisa e divulgação científica em música e performance de trombone.'],

    ['titulo'=>'Métodos e Pesquisa em Administração', 'subtitulo'=>'MEPAD',
     'caminho'=>'mepad',       'qualis'=>'', 'issn'=>'2525-3867',
     'area'=>'Administração', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/mepad.png',
     'desc'=>'Publicação voltada à divulgação de pesquisas em Administração, com ênfase em métodos quantitativos e qualitativos aplicados à gestão.'],

    ['titulo'=>'Data Science and Business Review', 'subtitulo'=>'DSBR',
     'caminho'=>'dsbr',        'qualis'=>'', 'issn'=>'2764-2682',
     'area'=>'Ciência da Computação', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/dsbr.png',
     'desc'=>'Publicação dedicada à ciência de dados aplicada a contextos de negócios e gestão empresarial.'],

    ['titulo'=>'Revista PRÁXIS: Educação e Diversidade', 'subtitulo'=>'Centro de Educação – UFPB',
     'caminho'=>'prx',         'qualis'=>'', 'issn'=>'2525-5355',
     'area'=>'Educação', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/praxis.png',
     'desc'=>'Publicação voltada à pesquisa em Educação, com ênfase em diversidade, inclusão e práxis pedagógica.'],

    ['titulo'=>'Gênero &amp; Direito', 'subtitulo'=>'Centro de Ciências Jurídicas – UFPB',
     'caminho'=>'ged',         'qualis'=>'', 'issn'=>'2179-7137',
     'area'=>'Direito', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/genero-direito.png',
     'desc'=>'Estimula o debate e a produção científica interdisciplinar sobre gênero e Direito, com foco na isonomia e transformação social.'],

    ['titulo'=>'Imaginário!', 'subtitulo'=>'Pós-Graduação em Letras – UFPB',
     'caminho'=>'imgn',        'qualis'=>'', 'issn'=>'2237-6933',
     'area'=>'Letras', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/imaginario.png',
     'desc'=>'Revista acadêmica dedicada ao imaginário, às artes e às humanidades, com publicação de artigos, ensaios e resenhas.'],

    ['titulo'=>'Diversidade Religiosa', 'subtitulo'=>'Pós-Graduação em Ciências das Religiões – UFPB',
     'caminho'=>'dr',          'qualis'=>'', 'issn'=>'2317-0476',
     'area'=>'Ciência da Religião', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/diversidade-religiosa.png',
     'desc'=>'Publicação dedicada ao estudo da diversidade religiosa e das culturas, fomentando o diálogo inter-religioso e a pesquisa nas Ciências das Religiões.'],

    ['titulo'=>'Informação &amp; Tecnologia', 'subtitulo'=>'Ciência da Informação e Arquivologia – UFPB',
     'caminho'=>'itec',        'qualis'=>'', 'issn'=>'2358-3908',
     'area'=>'Ciência da Informação', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/info-e-tec.png',
     'desc'=>'Publicação dedicada à pesquisa em Ciência da Informação, Arquivologia e Biblioteconomia, com ênfase nas interfaces com as tecnologias digitais.'],

    ['titulo'=>'Revista Economia e Desenvolvimento', 'subtitulo'=>'Pós-Graduação em Economia – UFPB',
     'caminho'=>'economia',    'qualis'=>'', 'issn'=>'2358-2510',
     'area'=>'Economia', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/economia-e-desenvolvimento.png',
     'desc'=>'Publicação científica voltada às áreas de Economia e Desenvolvimento Regional, com destaque para temas de economia nordestina.'],

    ['titulo'=>'Revista Logos &amp; Existência', 'subtitulo'=>'Teologia e Ciências das Religiões – UFPB',
     'caminho'=>'le',          'qualis'=>'', 'issn'=>'2316-9923',
     'area'=>'Ciência da Religião', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/logos.png',
     'desc'=>'Periódico dedicado ao estudo das interfaces entre fé, razão e existência, nas perspectivas da Teologia e das Ciências das Religiões.'],

    ['titulo'=>'Revista Paraibana de História', 'subtitulo'=>'Departamento de História – UFPB',
     'caminho'=>'rph',         'qualis'=>'', 'issn'=>'2446-5852',
     'area'=>'História', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/revista-pb-historia.png',
     'desc'=>'Publicação dedicada à pesquisa histórica com ênfase na história da Paraíba e do Nordeste.'],

    ['titulo'=>'Cultura Oriental', 'subtitulo'=>'Letras Orientais – UFPB',
     'caminho'=>'co',          'qualis'=>'', 'issn'=>'2358-5021',
     'area'=>'Letras', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/cultura-oriental.png',
     'desc'=>'Publicação dedicada ao estudo das línguas, literaturas e culturas orientais no contexto brasileiro e ibero-americano.'],

    ['titulo'=>'Turis Nostrum', 'subtitulo'=>'Pós-Graduação em Turismo – UFPB',
     'caminho'=>'tn',          'qualis'=>'', 'issn'=>'2316-4530',
     'area'=>'Turismo', 'situacao'=>'Não Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/tn.jpg',
     'desc'=>'Periódico semestral dedicado à divulgação de artigos e resenhas sobre Turismo, com ênfase em cultura e desenvolvimento.'],

    ['titulo'=>'Extensão Cidadã', 'subtitulo'=>'Revista Eletrônica – UFPB',
     'caminho'=>'extensaocidada', 'qualis'=>'', 'issn'=>'1982-2138',
     'area'=>'Extensão Universitária', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/extensaocidada.jpg',
     'desc'=>'Divulga ações e reflexões sobre extensão universitária, fomentando o diálogo entre a universidade e a sociedade.'],

    ['titulo'=>'Teoria Política &amp; Social', 'subtitulo'=>'Pós-Graduação em Serviço Social – UFPB',
     'caminho'=>'tps',         'qualis'=>'', 'issn'=>'2176-5332',
     'area'=>'Serviço Social', 'situacao'=>'Não Correntes', 'periodicidade'=>'Semestral',
     'img'=>'images/tps.jpg',
     'desc'=>'Periódico semestral dedicado às temáticas da política e do social, comprometido com a democracia e a justiça social.'],

    ['titulo'=>'Verba Juris', 'subtitulo'=>'Anuário da Pós-Graduação em Direito – UFPB',
     'caminho'=>'vj',          'qualis'=>'', 'issn'=>'1678-183X',
     'area'=>'Direito', 'situacao'=>'Não Correntes', 'periodicidade'=>'Anual',
     'img'=>'images/vj.jpg',
     'desc'=>'Publicação anual do Programa de Pós-Graduação em Ciências Jurídicas da UFPB, voltada à difusão de pesquisas no campo do Direito e suas interfaces.'],

    ['titulo'=>'Revista PetrART', 'subtitulo'=>'Arte Rupestre e Patrimônio Arqueológico',
     'caminho'=>'petrart',     'qualis'=>'', 'issn'=>'',
     'area'=>'Arqueologia', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/petrart.png',
     'desc'=>'Publicação dedicada à arte rupestre e ao patrimônio arqueológico do Nordeste brasileiro.'],

    ['titulo'=>'AUTOGESTÃO', 'subtitulo'=>'Economia dos Trabalhadores &amp; Educação Popular',
     'caminho'=>'autogestao',  'qualis'=>'', 'issn'=>'',
     'area'=>'Economia', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/autogestao.png',
     'desc'=>'Periódico do NUPLAR/UFPB dedicado ao campo transdisciplinar da autogestão social, economia solidária e educação popular.'],

    ['titulo'=>'Revista Estudos Geoambientais', 'subtitulo'=>'Ecologia – UFPB',
     'caminho'=>'geo',         'qualis'=>'', 'issn'=>'',
     'area'=>'Geografia', 'situacao'=>'Não Correntes', 'periodicidade'=>'Quadrimestral',
     'img'=>'images/geo.jpg',
     'desc'=>'Publicação quadrimestral vinculada ao grupo GeodiversidadePB, dedicada à Geografia, Geologia, Climatologia, Gestão Ambiental e Ecologia.'],

    ['titulo'=>'Comunicação Audiovisual', 'subtitulo'=>'Graduação em Radialismo – UFPB',
     'caminho'=>'palavrar',    'qualis'=>'', 'issn'=>'',
     'area'=>'Comunicação', 'situacao'=>'Não Correntes', 'periodicidade'=>'Semestral',
     'img'=>'',
     'desc'=>'Publicação semestral que divulga TCCs e artigos do curso de Radialismo da UFPB, estimulando a pesquisa e a iniciação científica no audiovisual.'],

    ['titulo'=>'Revista de Arqueologia', 'subtitulo'=>'Sociedade de Arqueologia Brasileira',
     'caminho'=>'ra',          'qualis'=>'', 'issn'=>'',
     'area'=>'Arqueologia', 'situacao'=>'Não Correntes', 'periodicidade'=>'Fluxo Contínuo',
     'img'=>'images/ra.png',
     'desc'=>'Publicação da Sociedade de Arqueologia Brasileira, referência na difusão de pesquisas arqueológicas nacionais e internacionais.'],
];

function qualisCor($q) {
    $map = [
        'A1' => ['bg'=>'#0f7a3d', 'txt'=>'#fff'],
        'A2' => ['bg'=>'#1c9350', 'txt'=>'#fff'],
        'A3' => ['bg'=>'#3daf6c', 'txt'=>'#fff'],
        'A4' => ['bg'=>'#8fd4ab', 'txt'=>'#1a1a1a'],
        'B1' => ['bg'=>'#173f7a', 'txt'=>'#fff'],
        'B2' => ['bg'=>'#2159a0', 'txt'=>'#fff'],
        'B3' => ['bg'=>'#3f7fc9', 'txt'=>'#fff'],
        'B4' => ['bg'=>'#8fb9e8', 'txt'=>'#1a1a1a'],
        'C'  => ['bg'=>'#888',    'txt'=>'#fff'],
        'NC' => ['bg'=>'#b0b0b0', 'txt'=>'#fff'],
    ];
    return $map[$q] ?? ['bg'=>'#b0b0b0', 'txt'=>'#fff'];
}

$totalRevistas = count($periodicos);

$niveis = ['A1','A2','A3','A4','B1','B2','B3','B4','C','NC'];

$areasUnicas = array_values(array_unique(array_column($periodicos, 'area')));
sort($areasUnicas, SORT_STRING | SORT_FLAG_CASE);

$ordemSituacao = ['Correntes', 'Incubados', 'Não Correntes', 'Anais de Eventos'];
$situacoesPresentes = array_unique(array_column($periodicos, 'situacao'));
$situacoesUnicas = array_values(array_intersect($ordemSituacao, $situacoesPresentes));

$periodicidadesUnicas = array_values(array_unique(array_column($periodicos, 'periodicidade')));
sort($periodicidadesUnicas, SORT_STRING | SORT_FLAG_CASE);
?>

<style>
/* ── Hero ── */
#per-hero {
    background: linear-gradient(135deg, #E8682A 0%, #c4521a 100%);
    padding: 56px 0 46px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
#per-hero::before {
    content:''; position:absolute; top:-60px; right:-60px;
    width:280px; height:280px; border-radius:50%;
    background:rgba(255,255,255,0.06); pointer-events:none;
}
#per-hero::after {
    content:''; position:absolute; bottom:-80px; left:-40px;
    width:220px; height:220px; border-radius:50%;
    background:rgba(255,255,255,0.05); pointer-events:none;
}
#per-hero .hero-content { position:relative; z-index:2; }
#per-hero h1 { font-size:2.1rem; font-weight:800; color:#fff !important; margin-bottom:8px; letter-spacing:-0.02em; }
#per-hero h1 .accent { color:#173f7a; }
#per-hero p  { font-size:1rem; opacity:.85; color:#fff !important; max-width:560px; margin:0 auto 26px; }

/* ── Busca (hero) ── */
.search-bar-wrap { max-width:640px; margin:0 auto; display:flex; background:#fff; border-radius:40px; box-shadow:0 8px 26px rgba(0,0,0,0.25); overflow:hidden; }
.search-bar-wrap input {
    flex:1; border:none; padding:15px 20px; font-size:1rem;
    outline:none; color:#3a3a3a; background:#fff;
}
.search-bar-wrap button {
    display:flex; align-items:center; gap:6px;
    border:none; background:linear-gradient(135deg, #173f7a 0%, #0d2b52 100%); color:#fff;
    font-weight:700; font-size:.92rem;
    padding:0 26px; cursor:pointer;
    transition:filter .15s, transform .1s;
}
.search-bar-wrap button:hover { filter:brightness(1.15); transform:translateY(-1px); }

/* ── Acessibilidade ── */
.sr-only {
    position:absolute; width:1px; height:1px; padding:0; margin:-1px;
    overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
}
:focus-visible { outline:3px solid #E8682A; outline-offset:3px; }

/* ── Corpo ── */
#per-lista { background:#f0f2f5; padding:30px 0 64px; }

.per-layout { display:flex; align-items:flex-start; gap:26px; }

/* ── Sidebar ── */
.per-sidebar {
    width:272px; flex-shrink:0;
    background:#fff; border:1px solid #eaeaea; border-radius:14px;
    box-shadow:0 1px 3px rgba(0,0,0,0.05);
    padding:20px; position:sticky; top:16px;
}
.per-sidebar-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.per-sidebar-head h2 { font-size:.98rem; font-weight:800; color:#E8682A; margin:0; }
.btn-limpar {
    background:#fff; border:1px solid #E8682A; color:#E8682A;
    border-radius:20px; font-size:.72rem; font-weight:700;
    padding:4px 14px; cursor:pointer; transition:background .15s;
}
.btn-limpar:hover { background:#fdf1ea; }

.per-field { margin-bottom:18px; }
.per-field label {
    display:block; font-size:.68rem; font-weight:800; letter-spacing:.06em;
    color:#8a8a8a; text-transform:uppercase; margin-bottom:6px;
}
.per-field input[type="text"], .per-field select {
    width:100%; border:1px solid #dedede; border-radius:8px;
    padding:9px 11px; font-size:.86rem; color:#333; background:#fbfbfc;
    outline:none;
}
.per-field input[type="text"]:focus, .per-field select:focus { border-color:#E8682A; }

.qualis-check-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px 9px; }
.qualis-check-item {
    position:relative;
    display:flex; align-items:center; justify-content:center;
    gap:6px; font-size:.82rem; font-weight:800; letter-spacing:.02em;
    padding:7px 8px; border-radius:20px; cursor:pointer;
    background:#fff; color:var(--qc-bg); border:1.5px solid var(--qc-bg);
    transition:background .15s, color .15s, transform .1s;
    user-select:none;
}
.qualis-check-item:hover { transform:translateY(-1px); }
.qualis-check-item input {
    position:absolute; opacity:0; width:100%; height:100%; margin:0; cursor:pointer;
}
.qualis-check-item.is-active {
    background:var(--qc-bg); color:var(--qc-txt); border-color:var(--qc-bg);
}
.qualis-check-item:has(input:focus-visible) { outline:3px solid #E8682A; outline-offset:2px; }

/* ── Barra superior (contagem + ordenar) ── */
.per-topbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:18px; }
.per-topbar .contagem { font-size:.92rem; color:#666; }
.per-topbar .contagem strong { color:#1a1a1a; font-weight:800; }
.per-topbar .ordenar { display:flex; align-items:center; gap:8px; font-size:.86rem; color:#666; }
.per-topbar select {
    border:1px solid #dedede; border-radius:8px; padding:7px 10px;
    font-size:.86rem; color:#333; background:#fff; outline:none;
}

/* ── Grid ── */
.per-main { flex:1; min-width:0; }
.per-grid {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
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
.per-card:hover { box-shadow:0 4px 20px rgba(0,0,0,0.12); transform:translateY(-2px); }
.per-card.oculto { display:none; }

.per-card .card-head { display:flex; align-items:flex-start; gap:12px; padding:18px 18px 8px; }
.per-card .card-thumb {
    width:52px; height:52px; flex-shrink:0; border-radius:8px; overflow:hidden;
    border:1px solid rgba(0,0,0,0.07); background:#f7f8fa;
    display:flex; align-items:center; justify-content:center;
}
.per-card .card-thumb img { width:100%; height:100%; object-fit:contain; padding:4px; }
.per-card .card-thumb-letter {
    width:52px; height:52px; flex-shrink:0; border-radius:8px; background:var(--qcor, #aaa);
    display:flex; align-items:center; justify-content:center; font-size:1.3rem; font-weight:900; color:#fff;
}
.per-card .card-head-info { flex:1; min-width:0; }
.per-card .card-titulo-h { margin:0 0 3px; }
.per-card .card-titulo {
    font-size:1rem; font-weight:800; color:#0d2b52;
    text-decoration:none; line-height:1.3; display:block; transition:color .15s;
}
.per-card .card-titulo:hover { color:#E8682A; text-decoration:none; }
.per-card .card-issn { font-size:.78rem; color:#999; margin-top:2px; }

.per-card .card-badges { display:flex; align-items:center; gap:6px; padding:8px 18px 0; flex-wrap:wrap; }
.qualis-chip {
    display:inline-flex; align-items:center;
    border-radius:6px; padding:3px 9px;
    font-size:.68rem; font-weight:800; letter-spacing:.04em;
}
.situacao-chip {
    display:inline-flex; align-items:center;
    border-radius:6px; padding:3px 9px;
    font-size:.68rem; font-weight:700;
    background:#e3f7ea; color:#1a8a48;
}
.periodicidade-chip {
    display:inline-flex; align-items:center;
    border-radius:6px; padding:3px 9px;
    font-size:.68rem; font-weight:700;
    background:#f0f0f0; color:#666;
}

/* Corpo */
.per-card .card-body { padding:10px 18px 16px; flex:1; display:flex; flex-direction:column; }
.per-card .card-desc { font-size:.83rem; color:#555; line-height:1.6; flex:1; margin:0 0 14px; }

/* Botões touch-friendly (mín. 44px) */
.per-card .card-actions { display:flex; gap:8px; }
.per-card .card-actions a {
    display:flex; align-items:center; justify-content:center;
    flex:1; min-height:44px; border-radius:8px; font-size:.82rem; font-weight:700;
    text-decoration:none; transition:filter .15s, transform .1s, background .15s;
}
.per-card .card-actions a:hover { transform:translateY(-1px); text-decoration:none; }
.per-card .card-actions a:focus-visible { outline:3px solid #020202; outline-offset:2px; }
.btn-acesso { background:#E8682A; color:#fff !important; }
.btn-acesso:hover { filter:brightness(.9); }
.btn-edicao { background:#fff; color:#173f7a !important; border:1.5px solid #173f7a; }
.btn-edicao:hover { background:#f2f6fc; }

/* ── Sem resultados ── */
#sem-resultados { display:none; text-align:center; padding:60px 0; color:#888; }
#sem-resultados .icon { font-size:2.5rem; margin-bottom:12px; }

/* ── Nota Qualis ── */
.qualis-nota {
    font-size:.78rem; color:#aaa; text-align:center;
    margin-top:36px; padding-top:20px; border-top:1px solid #e4e4e4;
}
.qualis-nota a { color:#E8682A; text-decoration:none; }
.qualis-nota a:hover { text-decoration:underline; }

/* ── Responsivo ── */
@media(max-width:900px){
    .per-layout { flex-direction:column; }
    .per-sidebar { width:100%; position:static; }
    .per-grid { grid-template-columns: 1fr; }
}
@media(max-width:600px){
    #per-hero h1 { font-size:1.4rem; }
    .search-bar-wrap { flex-direction:column; border-radius:16px; }
    .search-bar-wrap button { padding:12px; justify-content:center; }
}
</style>

<!-- Hero -->
<section id="per-hero">
    <div class="container hero-content">
        <p>Explore nossos periódicos científicos em acesso aberto e encontre o ideal para publicar sua pesquisa.</p>

        <div role="search" class="search-bar-wrap">
            <label for="buscaHero" class="sr-only">Pesquisar periódico por nome, área ou ISSN</label>
            <input type="search" id="buscaHero"
                   placeholder="Nome, área ou ISSN…"
                   oninput="filtrarTudo('hero')"
                   autocomplete="off"
                   aria-label="Pesquisar periódico por nome, área ou ISSN">
            <button type="button" onclick="filtrarTudo('hero')" aria-label="Buscar">🔍 Buscar</button>
        </div>
    </div>
</section>

<!-- Lista -->
<section id="per-lista">
<div class="container">

<div class="per-layout">

    <!-- Sidebar de busca avançada -->
    <aside class="per-sidebar" aria-label="Busca avançada">
        <div class="per-sidebar-head">
            <h2>🔍 Busca Avançada</h2>
            <button type="button" class="btn-limpar" onclick="limparFiltros()">Limpar</button>
        </div>

        <div class="per-field">
            <label for="buscaSidebar">Nome / ISSN</label>
            <input type="text" id="buscaSidebar" placeholder="Ex: Informação, 1809-4783…"
                   oninput="filtrarTudo('sidebar')" autocomplete="off">
        </div>

        <div class="per-field">
            <label for="filtroSituacao">Periódicos</label>
            <select id="filtroSituacao" onchange="filtrarTudo()">
                <option value="todos">Todos</option>
                <?php foreach($situacoesUnicas as $s): ?>
                <option value="<?=htmlspecialchars($s)?>"><?=htmlspecialchars($s)?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="per-field">
            <label for="filtroArea">Área do Conhecimento</label>
            <select id="filtroArea" onchange="filtrarTudo()">
                <option value="todas">Todas as áreas</option>
                <?php foreach($areasUnicas as $a): ?>
                <option value="<?=htmlspecialchars($a)?>"><?=htmlspecialchars($a)?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="per-field">
            <label>Qualis CAPES</label>
            <div class="qualis-check-grid">
                <?php foreach($niveis as $n): $qc = qualisCor($n); ?>
                <label class="qualis-check-item" style="--qc-bg:<?=$qc['bg']?>; --qc-txt:<?=$qc['txt']?>;">
                    <input type="checkbox" class="qualis-check" value="<?=$n?>"
                           onchange="this.closest('.qualis-check-item').classList.toggle('is-active', this.checked); filtrarTudo()">
                    <?=$n?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="per-field" style="margin-bottom:0;">
            <label for="filtroPeriodicidade">Periodicidade</label>
            <select id="filtroPeriodicidade" onchange="filtrarTudo()">
                <option value="todas">Todas</option>
                <?php foreach($periodicidadesUnicas as $per): ?>
                <option value="<?=htmlspecialchars($per)?>"><?=htmlspecialchars($per)?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </aside>

    <!-- Conteúdo principal -->
    <div class="per-main">

        <div class="per-topbar">
            <div class="contagem">Exibindo <strong id="contadorResultados"><?=$totalRevistas?></strong> periódicos</div>
            <div class="ordenar">
                <span>Ordenar:</span>
                <select id="ordenarSelect" onchange="ordenar()">
                    <option value="az">A → Z</option>
                    <option value="za">Z → A</option>
                    <option value="qualis">Qualis (melhor primeiro)</option>
                </select>
            </div>
        </div>

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
             data-qualis="<?=$p['qualis']?>"
             data-area="<?=htmlspecialchars($p['area'])?>"
             data-situacao="<?=htmlspecialchars($p['situacao'])?>"
             data-periodicidade="<?=htmlspecialchars($p['periodicidade'])?>">

            <!-- Cabeçalho: miniatura + título + ISSN -->
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
                    <?php if(!empty($p['issn'])): ?>
                    <div class="card-issn">e-ISSN: <?=$p['issn']?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Badges: Qualis + Situação -->
            <div class="card-badges">
                <?php if(!empty($p['qualis'])): ?>
                <span class="qualis-chip"
                      style="background:<?=$c['bg']?>;color:<?=$c['txt']?>"
                      aria-label="Qualis <?=$p['qualis']?>"><?=$p['qualis']?></span>
                <?php endif; ?>
                <span class="situacao-chip"><?=htmlspecialchars($p['situacao'])?></span>
                <span class="periodicidade-chip"><?=htmlspecialchars($p['periodicidade'])?></span>
            </div>

            <!-- Corpo -->
            <div class="card-body">
                <p class="card-desc"><?=$p['desc']?></p>
                <div class="card-actions">
                    <a class="btn-acesso"
                       href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Acessar <?=htmlspecialchars($tPlain)?>">📖 Acessar</a>
                    <a class="btn-edicao"
                       href="https://periodicos.ufpb.br/index.php/<?=$p['caminho']?>/issue/current"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Edição atual de <?=htmlspecialchars($tPlain)?>">🗓️ Edição Atual</a>
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

    </div><!-- /.per-main -->

</div><!-- /.per-layout -->
</div>
</section>

<script>
function removerAcentos(s){ return s.normalize('NFD').replace(/[̀-ͯ]/g,'').toLowerCase(); }

function coletarQualisSelecionados(){
    return Array.from(document.querySelectorAll('.qualis-check:checked')).map(function(cb){ return cb.value; });
}

function filtrarTudo(origem){
    var buscaHero = document.getElementById('buscaHero');
    var buscaSide = document.getElementById('buscaSidebar');

    // Mantém os dois campos de busca sincronizados
    var valor = origem === 'sidebar' ? buscaSide.value : buscaHero.value;
    if(origem === 'sidebar'){ buscaHero.value = valor; } else { buscaSide.value = valor; }

    var q = removerAcentos(valor.trim());
    var termos = q.split(/\s+/).filter(Boolean);
    var issnTerm = q.replace(/-/g,'');

    var situacao      = document.getElementById('filtroSituacao').value;
    var area          = document.getElementById('filtroArea').value;
    var periodicidade = document.getElementById('filtroPeriodicidade').value;
    var qualisSel     = coletarQualisSelecionados();

    var total = 0;
    document.querySelectorAll('.per-card').forEach(function(card){
        var titulo    = removerAcentos(card.dataset.titulo||'');
        var subtitulo = removerAcentos(card.dataset.subtitulo||'');
        var areaTxt   = removerAcentos(card.dataset.area||'');
        var texto     = (titulo + ' ' + subtitulo + ' ' + areaTxt).trim();
        var issn      = (card.dataset.issn||'').replace(/-/g,'');

        var matchIssn   = issnTerm.length>0 && issn.indexOf(issnTerm)>=0;
        var matchTexto  = termos.length>0 && termos.every(function(t){ return texto.indexOf(t)>=0; });
        var matchBusca  = !q || matchTexto || matchIssn;

        var matchSituacao      = situacao === 'todos' || card.dataset.situacao === situacao;
        var matchArea           = area === 'todas' || card.dataset.area === area;
        var matchPeriodicidade  = periodicidade === 'todas' || card.dataset.periodicidade === periodicidade;
        var matchQualis         = qualisSel.length === 0 || qualisSel.indexOf(card.dataset.qualis) >= 0;

        var show = matchBusca && matchSituacao && matchArea && matchPeriodicidade && matchQualis;
        card.classList.toggle('oculto', !show);
        if(show) total++;
    });

    document.getElementById('contadorResultados').textContent = total;
    document.getElementById('sem-resultados').style.display = total===0 ? 'block' : 'none';
}

function limparFiltros(){
    document.getElementById('buscaHero').value = '';
    document.getElementById('buscaSidebar').value = '';
    document.getElementById('filtroSituacao').value = 'todos';
    document.getElementById('filtroArea').value = 'todas';
    document.getElementById('filtroPeriodicidade').value = 'todas';
    document.querySelectorAll('.qualis-check').forEach(function(cb){
        cb.checked = false;
        cb.closest('.qualis-check-item').classList.remove('is-active');
    });
    document.getElementById('ordenarSelect').value = 'az';
    ordenar();
    filtrarTudo();
}

function ordenar(){
    var sel  = document.getElementById('ordenarSelect').value;
    var grid = document.getElementById('per-grid');
    var rank = {'A1':1,'A2':2,'A3':3,'A4':4,'B1':5,'B2':6,'B3':7,'B4':8,'C':9,'NC':10};
    var cards = Array.from(grid.querySelectorAll('.per-card'));

    cards.sort(function(a,b){
        if(sel === 'az') return a.dataset.titulo.localeCompare(b.dataset.titulo, 'pt-BR');
        if(sel === 'za') return b.dataset.titulo.localeCompare(a.dataset.titulo, 'pt-BR');
        if(sel === 'qualis') return (rank[a.dataset.qualis]||99) - (rank[b.dataset.qualis]||99);
        return 0;
    });

    cards.forEach(function(c){ grid.appendChild(c); });
}

// Estado inicial: ordena A→Z para bater com o seletor padrão
ordenar();
</script>

<?php include 'footer.html'; ?>
