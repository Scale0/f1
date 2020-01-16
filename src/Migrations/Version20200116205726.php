<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200116205726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE driver_constructor_season (id INT AUTO_INCREMENT NOT NULL, driver_id INT NOT NULL, constructor_id INT NOT NULL, season_id INT NOT NULL, INDEX IDX_78006F15C3423909 (driver_id), INDEX IDX_78006F152D98BF9 (constructor_id), INDEX IDX_78006F154EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE driver_constructor_season ADD CONSTRAINT FK_78006F15C3423909 FOREIGN KEY (driver_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE driver_constructor_season ADD CONSTRAINT FK_78006F152D98BF9 FOREIGN KEY (constructor_id) REFERENCES constructor (id)');
        $this->addSql('ALTER TABLE driver_constructor_season ADD CONSTRAINT FK_78006F154EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE driver_constructor_season');
    }
}
