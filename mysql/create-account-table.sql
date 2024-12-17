CREATE TABLE IF NOT EXISTS accounts (
  app_name    VARCHAR(24)       NOT NULL,
  url         VARCHAR(36)       DEFAULT NULL,
  comment     TINYTEXT          DEFAULT NULL,
  username    VARCHAR(36)       DEFAULT NULL,
  password    VARBINARY(512)    NOT NULL,
  timestamp   TIME              NOT NULL,
  FOREIGN KEY (username) REFERENCES users(username) ON UPDATE CASCADE ON DELETE CASCADE,

  PRIMARY KEY (app_name)
);