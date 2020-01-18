<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200111112640 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAF64D218E');
        $this->addSql('DROP INDEX IDX_DA6FBBAF64D218E ON race');
        $this->addSql('ALTER TABLE race CHANGE location_id circuit_id INT NOT NULL');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAFCF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id)');
        $this->addSql('CREATE INDEX IDX_DA6FBBAFCF2182C8 ON race (circuit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAFCF2182C8');
        $this->addSql('DROP INDEX IDX_DA6FBBAFCF2182C8 ON race');
        $this->addSql('ALTER TABLE race CHANGE circuit_id location_id INT NOT NULL');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAF64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_DA6FBBAF64D218E ON race (location_id)');
    }
}
