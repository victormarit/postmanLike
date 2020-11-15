<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201115105819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, methode VARCHAR(255) NOT NULL, header VARCHAR(1000) DEFAULT NULL, body VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_request_api (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, api_id_id INT DEFAULT NULL, INDEX IDX_C93450D69D86650F (user_id_id), INDEX IDX_C93450D65BD1CA87 (api_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_request_api ADD CONSTRAINT FK_C93450D69D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_request_api ADD CONSTRAINT FK_C93450D65BD1CA87 FOREIGN KEY (api_id_id) REFERENCES api (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_request_api DROP FOREIGN KEY FK_C93450D65BD1CA87');
        $this->addSql('ALTER TABLE user_request_api DROP FOREIGN KEY FK_C93450D69D86650F');
        $this->addSql('DROP TABLE api');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_request_api');
    }
}
