CREATE TABLE IF NOT EXISTS accounts (
  app_name    VARCHAR(24)   NOT NULL,
  url         VARCHAR(36)   DEFAULT NULL,
  password    VARCHAR(36)   NOT NULL,
  comment     TINYTEXT      DEFAULT NULL,
  username    VARCHAR(24)   NOT NULL,
  timestamp   TIME          NOT NULL,
  FOREIGN KEY (username) REFERENCES users(username),

  PRIMARY KEY (app_name)
);