CREATE OR REPLACE FUNCTION update_last_modification_date_column()
RETURNS TRIGGER AS $$
BEGIN
   NEW.last_modification_date = CURRENT_TIMESTAMP;
   RETURN NEW;
END;
$$ language 'plpgsql';

DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
    id SERIAL PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,

    CONSTRAINT uc_countries_code UNIQUE (code),
    CONSTRAINT uc_countries_name UNIQUE (name)
);

DROP TABLE IF EXISTS account_types;
CREATE TABLE account_types (
    id SERIAL PRIMARY KEY,
    value VARCHAR(255) NOT NULL,

    CONSTRAINT uc_account_types_value UNIQUE (value)
);

DROP TABLE IF EXISTS accounts;
CREATE TABLE accounts (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    salt VARCHAR(255) NOT NULL,
    verified BOOL NOT NULL DEFAULT false,
    enabled BOOL NOT NULL DEFAULT true,
    full_name VARCHAR(255),
    year_of_birth INTEGER,
    registration_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_password_modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_sign_in_date TIMESTAMP,
    verification_token VARCHAR(255),

    account_type_id INTEGER NOT NULL,
    country_id INTEGER,

    CONSTRAINT uc_accounts_email UNIQUE (email),

    CONSTRAINT fk_accounts_account_types FOREIGN KEY (account_type_id)
        REFERENCES account_types(id) ON UPDATE CASCADE,
    CONSTRAINT fk_accounts_countries FOREIGN KEY (country_id)
        REFERENCES countries(id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE INDEX index_accounts_email ON accounts (email);

CREATE TRIGGER trigger_accounts_last_modification_date BEFORE UPDATE
    ON accounts FOR EACH ROW EXECUTE PROCEDURE
    update_last_modification_date_column();

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
    id SERIAL PRIMARY KEY,
    value VARCHAR(255) NOT NULL,
    color VARCHAR(255) NOT NULL,
    date_added TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    account_id INTEGER NOT NULL,

    CONSTRAINT uc_languages_value UNIQUE (value, account_id),

    CONSTRAINT fk_languages_accounts FOREIGN KEY (account_id)
        REFERENCES accounts(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TRIGGER trigger_languages_last_modification_date BEFORE UPDATE
    ON languages FOR EACH ROW EXECUTE PROCEDURE
    update_last_modification_date_column();

DROP TABLE IF EXISTS words;
CREATE TABLE words (
    id SERIAL PRIMARY KEY,
    value VARCHAR(255) NOT NULL,
    phonetic VARCHAR(255),
    date_added TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    enabled BOOL NOT NULL DEFAULT true,
    phrase BOOL NOT NULL DEFAULT false,

    account_id INTEGER NOT NULL,
    language_id INTEGER NOT NULL,

    CONSTRAINT fk_words_accounts FOREIGN KEY (account_id)
        REFERENCES accounts(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_words_languages FOREIGN KEY (language_id)
        REFERENCES languages(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TRIGGER trigger_words_last_modification_date BEFORE UPDATE
    ON words FOR EACH ROW EXECUTE PROCEDURE
    update_last_modification_date_column();

DROP TABLE IF EXISTS links;
CREATE TABLE links (
    id SERIAL PRIMARY KEY,
    word1_id INTEGER NOT NULL,
    word2_id INTEGER NOT NULL,
    date_added TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    streak INTEGER NOT NULL DEFAULT 0,
    prioritized BOOL NOT NULL DEFAULT true,
    known BOOL NOT NULL DEFAULT false,

    account_id INTEGER NOT NULL,

    CONSTRAINT uc_links UNIQUE (word1_id, word2_id),

    CONSTRAINT fk_links_accounts FOREIGN KEY (account_id)
        REFERENCES accounts(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_links_word1 FOREIGN KEY (word1_id)
        REFERENCES words(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_links_word2 FOREIGN KEY (word2_id)
        REFERENCES words(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TRIGGER trigger_links_last_modification_date BEFORE UPDATE
    ON links FOR EACH ROW EXECUTE PROCEDURE
    update_last_modification_date_column();

DROP TABLE IF EXISTS feedback;
CREATE TABLE feedback (
    id SERIAL PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_added TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    origin VARCHAR(255) NOT NULL,

    account_id INTEGER NOT NULL,

    CONSTRAINT fk_feedback_accounts FOREIGN KEY (account_id)
        REFERENCES accounts(id) ON UPDATE CASCADE ON DELETE SET NULL
);

DROP TABLE IF EXISTS tests;
CREATE TABLE tests (
    id SERIAL PRIMARY KEY,
    test_type VARCHAR(255) NOT NULL,
    start_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    language_from VARCHAR(255) NOT NULL,
    language_to VARCHAR(255) NOT NULL,

    account_id INTEGER NOT NULL,

    CONSTRAINT fk_tests_accounts FOREIGN KEY (account_id)
        REFERENCES accounts(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS test_items;
CREATE TABLE test_items (
    id SERIAL PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    user_answer VARCHAR(255) NOT NULL,
    correct BOOL NOT NULL,

    test_id INTEGER NOT NULL,

    CONSTRAINT fk_test_items_tests FOREIGN KEY (test_id)
        REFERENCES tests(id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS answer_options;
CREATE TABLE answer_options (
    id SERIAL PRIMARY KEY,
    value VARCHAR(255) NOT NULL,
    correct BOOL NOT NULL DEFAULT true,

    test_item_id INTEGER NOT NULL,

    CONSTRAINT fk_answer_options_test_items FOREIGN KEY (test_item_id)
        REFERENCES test_items(id) ON UPDATE CASCADE ON DELETE CASCADE
);
