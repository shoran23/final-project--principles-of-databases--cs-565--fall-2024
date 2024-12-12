CREATE TABLE IF NOT EXISTS users (
  first_name  VARCHAR(24)   NOT NULL,
  last_name   VARCHAR(24)   NOT NULL,
  username    VARCHAR(24)   NOT NULL,
  email       VARCHAR(36)   NOT NULL,

  PRIMARY KEY (username)
);