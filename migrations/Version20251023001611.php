<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023001611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du champ ref UNIQUE à la table book et remplissage des valeurs existantes';
    }

    public function up(Schema $schema): void
    {
        // 1. Ajouter la colonne nullable
        $this->addSql('ALTER TABLE book ADD ref VARCHAR(50) DEFAULT NULL');

        // 2. Remplir toutes les lignes existantes avec une valeur unique
        $this->addSql('UPDATE book SET ref = CONCAT("BK-", UPPER(UUID())) WHERE ref IS NULL');

        // 3. Rendre la colonne NOT NULL et UNIQUE
        $this->addSql('ALTER TABLE book MODIFY ref VARCHAR(50) NOT NULL UNIQUE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book DROP COLUMN ref');
    }
}
