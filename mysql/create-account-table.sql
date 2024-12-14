CREATE TABLE IF NOT EXISTS accounts (
  app_name    VARCHAR(24)       NOT NULL,
  url         VARCHAR(36)       DEFAULT NULL,
  comment     TINYTEXT          DEFAULT NULL,

  PRIMARY KEY (app_name)
);