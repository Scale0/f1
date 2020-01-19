<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200119213824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE race_result CHANGE fastest_lap fastest_lap INT DEFAULT NULL, CHANGE fastest_lap_rank fastest_lap_rank INT DEFAULT NULL, CHANGE fastest_lap_time fastest_lap_time VARCHAR(11) DEFAULT NULL, CHANGE avg_speed avg_speed VARCHAR(11) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE race_result CHANGE fastest_lap fastest_lap INT NOT NULL, CHANGE fastest_lap_rank fastest_lap_rank INT NOT NULL, CHANGE fastest_lap_time fastest_lap_time VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE avg_speed avg_speed VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
