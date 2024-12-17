INSERT INTO accounts
    (app_name, url, comment, username, password, timestamp)
VALUES
    (
     "Trello",
     "trello.com",
     "Use this application to track project status.",
     "shoran23",
     AES_ENCRYPT("passwordtrello", @key_str, @init_vector),
     NOW()
    ),
    (
        "Ganttic",
        "ganttic.com",
        "Use this application to track project status.",
        "shoran23",
        AES_ENCRYPT("passwordtrello", @key_str, @init_vector),
        NOW()
    );