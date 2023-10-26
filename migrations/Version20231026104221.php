<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026104221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66EA56AA7A');
        $this->addSql('DROP INDEX IDX_23A0E66EA56AA7A ON article');
        $this->addSql('ALTER TABLE article DROP commande_article_id');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DEA56AA7A');
        $this->addSql('DROP INDEX IDX_6EEAA67DEA56AA7A ON commande');
        $this->addSql('ALTER TABLE commande DROP commande_article_id');
        $this->addSql('ALTER TABLE commande_article ADD article_id INT DEFAULT NULL, ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC67294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_F4817CC67294869C ON commande_article (article_id)');
        $this->addSql('CREATE INDEX IDX_F4817CC682EA2E54 ON commande_article (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD commande_article_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66EA56AA7A FOREIGN KEY (commande_article_id) REFERENCES commande_article (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_23A0E66EA56AA7A ON article (commande_article_id)');
        $this->addSql('ALTER TABLE commande ADD commande_article_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DEA56AA7A FOREIGN KEY (commande_article_id) REFERENCES commande_article (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6EEAA67DEA56AA7A ON commande (commande_article_id)');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY FK_F4817CC67294869C');
        $this->addSql('ALTER TABLE commande_article DROP FOREIGN KEY FK_F4817CC682EA2E54');
        $this->addSql('DROP INDEX IDX_F4817CC67294869C ON commande_article');
        $this->addSql('DROP INDEX IDX_F4817CC682EA2E54 ON commande_article');
        $this->addSql('ALTER TABLE commande_article DROP article_id, DROP commande_id');
    }
}
