INSERT INTO accounts
    (app_name, url, comment, username, password, timestamp)
VALUES
    (
     "Trello",
     "trello.com",
     "Use this application to track project status.",
     "scotthoran",
     AES_ENCRYPT("passwordtrello", @key_str, @init_vector),
     NOW()
    ),
    (
    "Ganttic",
    "ganttic.com",
    "Use this application to track project status.",
    "scotthoran",
    AES_ENCRYPT("passwordtrello", @key_str, @init_vector),
    NOW()
    ),
    (
    "Github",
    "github.com",
    "Use this to store code repos.",
    "shoran23",
    AES_ENCRYPT("passwordgithub", @key_str, @init_vector),
    NOW()
    ),
    (
     "Gmail",
     "gmail.com",
     "Personal email.",
     "scottyh",
     AES_ENCRYPT("passwordgmail", @key_str, @init_vector),
     NOW()
    ),
    (
     "Credit Karma",
     "creditkarma.com",
     "Tracking credit for person finance.",
     "scottyh",
     AES_ENCRYPT("passwordcredkarma", @key_str, @init_vector),
     NOW()
    ),
    (
     "Spotify",
     "spotify.com",
     "Listening to music and making playlists.",
     "scottyh",
     AES_ENCRYPT("passwordspotify", @key_str, @init_vector),
     NOW()
    ),
    (
     "Linkedin",
     "linkedin.com",
     "Professional networking.",
     "shoran23",
     AES_ENCRYPT("passwordlinkedin", @key_str, @init_vector),
     NOW()
    ),
    (
     "Duolingo",
     "duolingo.com",
     "Learn new languages",
     "shoran23",
     AES_ENCRYPT("passwordduolingo", @key_str, @init_vector),
     NOW()
    ),
    (
     "Hulu",
     "hulu.com",
     "Watching TV and movies",
     "scottyh",
     AES_ENCRYPT("passwordhulu", @key_str, @init_vector),
     NOW()
    ),
    (
     "Teams",
     "teams.com",
     "Connect with coworkers",
     "scotthoran",
     AES_ENCRYPT("passwordteams", @key_str, @init_vector),
     NOW()
    );