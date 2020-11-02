<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102211839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_request_api (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, api_id_id INT NOT NULL, INDEX IDX_C93450D69D86650F (user_id_id), INDEX IDX_C93450D65BD1CA87 (api_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_request_api ADD CONSTRAINT FK_C93450D69D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_request_api ADD CONSTRAINT FK_C93450D65BD1CA87 FOREIGN KEY (api_id_id) REFERENCES api (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_request_api');
    }
}
