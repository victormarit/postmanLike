<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108223825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api ADD header_tokken VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_request_api CHANGE user_id_id user_id_id INT DEFAULT NULL, CHANGE api_id_id api_id_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api DROP header_tokken');
        $this->addSql('ALTER TABLE user_request_api CHANGE user_id_id user_id_id INT NOT NULL, CHANGE api_id_id api_id_id INT NOT NULL');
    }
}
