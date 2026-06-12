-- Seed Data
-- All seeded passwords are: "password"
-- bcrypt hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- Assumption for the in-app demo-data loader:
--   a real setup admin already exists as user id 1
--   this file then inserts demo users as ids 2..7

USE `rooted`;

-- Ensure the connection interprets this file as UTF-8.
-- Without this, accented characters (é, ã, ç) may be stored
-- as Latin-1 bytes, causing mojibake when read back as UTF-8.
SET NAMES utf8mb4;

-- Users
INSERT INTO `users` (`email`, `password`, `role`, `email_verified`) VALUES
    ('admin@rooted.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1),
    ('moderator@rooted.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator', 1),
    ('maria@rooted.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator', 1),
    ('joao@rooted.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 1),
    ('ana@rooted.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 1),
    ('pedro@rooted.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 0);

-- Garden locations (used by the Garden Map). Only some demo users share a location.
-- joao -> Lisboa
UPDATE `users` SET `latitude` = 38.722300, `longitude` = -9.139300 WHERE `email` = 'joao@rooted.local';
-- ana -> Porto
UPDATE `users` SET `latitude` = 41.157900, `longitude` = -8.629100 WHERE `email` = 'ana@rooted.local';
-- maria -> Coimbra
UPDATE `users` SET `latitude` = 40.203300, `longitude` = -8.410300 WHERE `email` = 'maria@rooted.local';

-- Tags  (primary = admin-created, secondary = moderator-created)
INSERT INTO `tags` (`name`, `type`, `user_id`) VALUES
    -- Primary tags (created by the real setup admin, id=1)
    ('Flores', 'primary',   1),
    ('Hortícolas', 'primary',   1),
    ('Suculentas', 'primary',   1),
    ('Árvores de Fruto', 'primary',   1),
    ('Aromáticas', 'primary',   1),
    ('Trepadeiras', 'primary',   1),
    -- Secondary tags (created by seeded moderators, ids 3-4)
    ('Rega Gota-a-Gota', 'secondary', 3),
    ('Cultivo Interior', 'secondary', 3),
    ('Compostagem', 'secondary', 4),
    ('Permacultura', 'secondary', 4),
    ('Jardim Vertical', 'secondary', 3),
    ('Polinizadores', 'secondary', 4);

-- Plants
INSERT INTO `plants` (`user_id`, `name`, `body`, `visibility`) VALUES
    -- By seeded moderator (id=3)
    (
        3,
        'Rosa Trepadeira',
        'A rosa trepadeira é uma planta vigorosa que pode atingir vários metros de altura. Ideal para cobrir pérgulas, muros e vedações. Floresce abundantemente na primavera e verão, produzindo cachos de flores perfumadas.',
        'public'
    ),

    (
        3,
        'Tomate Coração de Boi',
        'Variedade tradicional portuguesa de tomate, conhecida pelo seu tamanho generoso e sabor intenso. Frutos com formato irregular, tipo coração, que podem atingir 500g. Excelente para saladas e para cozinhar.',
        'public'
    ),

    (3, 'Aloe Vera',
     'Planta suculenta muito resistente, originária do Norte de África. Conhecida pelas propriedades medicinais do seu gel. Requer pouca água e adapta-se bem a interiores com boa luminosidade.',
     'public'),

    (3, 'Limoeiro',
     'Árvore de fruto de porte médio, perene, que produz limões ao longo de quase todo o ano em climas mediterrânicos. Prefere solos bem drenados e exposição solar direta.',
     'internal'),

    -- By seeded moderator maria (id=4)
    (4, 'Manjericão',
     'Erva aromática anual muito utilizada na cozinha mediterrânica. De crescimento rápido, prefere locais quentes e abrigados. Ideal para cultivo em vaso no parapeito da janela.',
     'public'),

    (4, 'Lavanda',
     'Arbusto perene aromático, originário da região mediterrânica. As suas flores roxas atraem abelhas e borboletas. Muito resistente à seca após estabelecida. Utilizada em perfumaria e como repelente natural.',
     'public'),

    (4, 'Monstera Deliciosa',
     'Planta tropical de interior com folhas grandes e fenestradas. Originária das florestas tropicais da América Central. Prefere luz indireta e rega moderada. As folhas podem atingir 90 cm de diâmetro.',
     'public'),

    (4, 'Morangueiro',
     'Planta rasteira perene que produz morangos saborosos na primavera e verão. Adapta-se bem a vasos e floreiras. Prefere solo rico em matéria orgânica e boa exposição solar.',
     'internal'),

    (4, 'Orquídea Phalaenopsis',
     'A orquídea-borboleta é uma das plantas de interior mais populares. Nativa do sudeste asiático, produz flores elegantes que podem durar meses. Prefere luz indireta e rega semanal por imersão.',
     'public'),

    (4, 'Hera',
     'Trepadeira perene de crescimento rápido, excelente para cobrir muros e paredes. Muito resistente e adaptável a diferentes condições de luz. Pode ser cultivada tanto no exterior como em vasos de interior.',
     'internal');

-- IDs: 1=Rosa, 2=Tomate, 3=Aloe, 4=Limoeiro, 5=Manjericão,
--      6=Lavanda, 7=Monstera, 8=Morangueiro, 9=Orquídea, 10=Hera

-- Media  (placeholder paths — files don't exist yet on disk)
INSERT INTO `media` (`plant_id`, `type`, `path`, `filename`, `mime_type`) VALUES
    (1, 'image', 'media/rosa-trepadeira-01.jpg',       'rosa-trepadeira-01.jpg',       'image/jpeg'),
    (1, 'image', 'media/rosa-trepadeira-02.jpg',       'rosa-trepadeira-02.jpg',       'image/jpeg'),
    (2, 'image', 'media/tomate-coracao-boi-01.jpg',    'tomate-coracao-boi-01.jpg',    'image/jpeg'),
    (2, 'video', 'media/tomate-plantacao.mp4',         'tomate-plantacao.mp4',         'video/mp4'),
    (3, 'image', 'media/aloe-vera-01.jpg',             'aloe-vera-01.jpg',             'image/jpeg'),
    (4, 'image', 'media/limoeiro-01.jpg',              'limoeiro-01.jpg',              'image/jpeg'),
    (4, 'image', 'media/limoeiro-02.jpg',              'limoeiro-02.jpg',              'image/jpeg'),
    (5, 'image', 'media/manjericao-01.jpg',            'manjericao-01.jpg',            'image/jpeg'),
    (5, 'audio', 'media/manjericao-dicas.mp3',         'manjericao-dicas.mp3',         'audio/mpeg'),
    (6, 'image', 'media/lavanda-01.jpg',               'lavanda-01.jpg',               'image/jpeg'),
    (6, 'image', 'media/lavanda-02.jpg',               'lavanda-02.jpg',               'image/jpeg'),
    (7, 'image', 'media/monstera-01.jpg',              'monstera-01.jpg',              'image/jpeg'),
    (8, 'image', 'media/morangueiro-01.jpg',           'morangueiro-01.jpg',           'image/jpeg'),
    (9, 'image', 'media/orquidea-01.jpg',              'orquidea-01.jpg',              'image/jpeg'),
    (9, 'image', 'media/orquidea-02.jpg',              'orquidea-02.jpg',              'image/jpeg'),
    (10, 'image', 'media/hera-01.jpg',                 'hera-01.jpg',                  'image/jpeg');

-- Plant ↔ Tag associations
INSERT INTO `plant_tag` (`plant_id`, `tag_id`) VALUES
    -- Rosa Trepadeira: Flores, Trepadeiras, Polinizadores
    (1, 1), (1, 6), (1, 12),
    -- Tomate Coração de Boi: Hortícolas, Compostagem
    (2, 2), (2, 9),
    -- Aloe Vera: Suculentas, Cultivo Interior
    (3, 3), (3, 8),
    -- Limoeiro: Árvores de Fruto, Rega Gota-a-Gota
    (4, 4), (4, 7),
    -- Manjericão: Aromáticas, Cultivo Interior
    (5, 5), (5, 8),
    -- Lavanda: Flores, Aromáticas, Polinizadores, Permacultura
    (6, 1), (6, 5), (6, 12), (6, 10),
    -- Monstera: Cultivo Interior
    (7, 8),
    -- Morangueiro: Hortícolas, Compostagem
    (8, 2), (8, 9),
    -- Orquídea: Flores, Cultivo Interior
    (9, 1), (9, 8),
    -- Hera: Trepadeiras, Jardim Vertical
    (10, 6), (10, 11);

-- Plant Meta
INSERT INTO `plant_meta` (`plant_id`, `key`, `value`) VALUES
    -- Rosa Trepadeira
    (1, 'Solo',             'Franco-argiloso'),
    (1, 'Exposição Solar',  'Sol pleno'),
    (1, 'Rega',             'Regular'),
    (1, 'Época de Floração','Primavera–Verão'),
    -- Tomate Coração de Boi
    (2, 'Solo',             'Rico em matéria orgânica'),
    (2, 'Exposição Solar',  'Sol pleno (6-8h)'),
    (2, 'Rega',             'Diária no verão'),
    (2, 'Época de Colheita','Julho–Setembro'),
    (2, 'Zona Climática',   'Temperada'),
    -- Aloe Vera
    (3, 'Solo',             'Arenoso, bem drenado'),
    (3, 'Exposição Solar',  'Luz indireta a sol pleno'),
    (3, 'Rega',             'Quinzenal'),
    (3, 'Temperatura Mín.', '10°C'),
    -- Limoeiro
    (4, 'Solo',             'Bem drenado, ligeiramente ácido'),
    (4, 'Exposição Solar',  'Sol pleno'),
    (4, 'Rega',             'Regular, sem encharcamento'),
    (4, 'Zona Climática',   'Mediterrânica'),
    -- Manjericão
    (5, 'Solo',             'Fértil, bem drenado'),
    (5, 'Exposição Solar',  'Sol pleno'),
    (5, 'Rega',             'Frequente, solo húmido'),
    (5, 'Ciclo',            'Anual'),
    -- Lavanda
    (6, 'Solo',             'Pobre, calcário, bem drenado'),
    (6, 'Exposição Solar',  'Sol pleno'),
    (6, 'Rega',             'Escassa (resistente à seca)'),
    (6, 'Zona Climática',   'Mediterrânica'),
    -- Monstera Deliciosa
    (7, 'Solo',             'Rico, bem drenado'),
    (7, 'Exposição Solar',  'Luz indireta'),
    (7, 'Rega',             'Semanal'),
    (7, 'Temperatura Mín.', '15°C'),
    (7, 'Humidade',         'Elevada'),
    -- Morangueiro
    (8, 'Solo',             'Rico em matéria orgânica, ácido (pH 5.5-6.5)'),
    (8, 'Exposição Solar',  'Sol pleno a meia-sombra'),
    (8, 'Rega',             'Regular'),
    (8, 'Época de Colheita','Maio–Julho'),
    -- Orquídea Phalaenopsis
    (9, 'Solo',             'Casca de pinheiro (substrato para orquídeas)'),
    (9, 'Exposição Solar',  'Luz indireta'),
    (9, 'Rega',             'Semanal por imersão'),
    (9, 'Temperatura Mín.', '18°C'),
    (9, 'Humidade',         'Moderada a elevada'),
    -- Hera
    (10, 'Solo',            'Qualquer, adaptável'),
    (10, 'Exposição Solar', 'Sombra a meia-sombra'),
    (10, 'Rega',            'Moderada'),
    (10, 'Crescimento',     'Rápido');

-- Subscriptions  (users subscribe to tags of interest)
INSERT INTO `subscriptions` (`user_id`, `tag_id`) VALUES
    -- joao subscribes to: Flores, Suculentas, Cultivo Interior
    (5, 1), (5, 3), (5, 8),
    -- ana subscribes to: Hortícolas, Aromáticas, Compostagem, Permacultura
    (6, 2), (6, 5), (6, 9), (6, 10),
    -- pedro subscribes to: Flores, Trepadeiras
    (7, 1), (7, 6),
    -- seeded moderator subscribes to: Polinizadores (to track content they care about)
    (3, 12);

-- Garden plants  (which catalog plants each user grows in their personal garden)
-- Drives the Garden Map together with the users' latitude/longitude above.
INSERT INTO `garden_plants` (`user_id`, `plant_id`, `notes`) VALUES
    -- joao (id=5), garden in Lisboa
    (5, 2, 'A crescer bem no canteiro das traseiras.'),
    (5, 5, 'No parapeito da cozinha.'),
    (5, 8, 'Em floreira na varanda.'),
    -- ana (id=6), garden in Porto
    (6, 6, 'Junto ao muro, atrai abelhas.'),
    (6, 3, 'Em vaso, com pouca rega.'),
    -- maria (id=4), garden in Coimbra
    (4, 1, 'Cobre a pérgula do quintal.'),
    (4, 7, 'Interior, com luz indireta.');

-- Settings  (default SMTP configuration — placeholders)
INSERT INTO `settings` (`key`, `value`) VALUES
    ('smtp_host',       'smtp.gmail.com'),
    ('smtp_port',       '465'),
    ('smtp_user',       'smiaux1@gmail.com'),
    ('smtp_password',   'ahysostilwavdxgc'),
    ('smtp_from_address','smiaux1@gmail.com'),
    ('smtp_from_name',  'smi'),
    ('app_name',        'smi'),
    ('app_url',         'http://localhost:8080');
