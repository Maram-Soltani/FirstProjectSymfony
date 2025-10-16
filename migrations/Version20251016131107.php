<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251016131107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE username username VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book ADD author_id INT NOT NULL, ADD publication_date DATE DEFAULT NULL, ADD enabled INT DEFAULT NULL, ADD published TINYINT(1) NOT NULL, DROP publicationDate, DROP author, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE category category VARCHAR(255) NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE username username VARCHAR(11) NOT NULL, CHANGE email email VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE book MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B ON book');
        $this->addSql('DROP INDEX `primary` ON book');
        $this->addSql('ALTER TABLE book ADD publicationDate DATE NOT NULL, ADD author VARCHAR(225) NOT NULL, DROP author_id, DROP publication_date, DROP enabled, DROP published, CHANGE id id INT NOT NULL, CHANGE category category VARCHAR(225) NOT NULL');
    }
}
