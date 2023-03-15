<?php

make_migrations_table();

$migrations_path = __DIR__ . '/../migrations';

$migrations = scandir($migrations_path);

foreach ($migrations as $migration) {
    if ($migration === '.' || $migration === '..' || is_dir($migration)) {
        continue;
    }

    $statements = include($migrations_path . '/' . $migration);

    $stmt = get_db()->prepare('SELECT id FROM migrations WHERE name=?');
    $stmt->execute([$migration]);

    if (!$stmt->fetch() === false) {
        continue;
    }

    try {
        foreach ($statements as $statement) {
            get_db()->exec($statement);
        }

        add_to_migrations_table($migration);
    } catch (Exception $exception) {
        throw new \Exception($exception->getMessage());
    }
}

function make_migrations_table(): void
{
    get_db()->exec(
        'CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
    );
}

function add_to_migrations_table(mixed $migration): void
{
    $query = 'INSERT INTO migrations (name) values (?)';
    $statement = get_db()->prepare($query);
    $statement->execute([$migration]);
}