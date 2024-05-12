<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502114722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE albums (id INT AUTO_INCREMENT NOT NULL, nomalbum VARCHAR(255) NOT NULL, date DATETIME NOT NULL, miniature VARCHAR(255) NOT NULL, nbrephotos INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date DATETIME NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, preview VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boutique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, emplacement VARCHAR(255) DEFAULT NULL, ouverture TIME NOT NULL, fermeture TIME NOT NULL, contacts VARCHAR(100) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carousel (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couts (id INT AUTO_INCREMENT NOT NULL, super DOUBLE PRECISION DEFAULT NULL, gasoil DOUBLE PRECISION DEFAULT NULL, petrole DOUBLE PRECISION DEFAULT NULL, ddo DOUBLE PRECISION DEFAULT NULL, ddoad DOUBLE PRECISION DEFAULT NULL, butane DOUBLE PRECISION DEFAULT NULL, btc DOUBLE PRECISION DEFAULT NULL, bt6kg DOUBLE PRECISION DEFAULT NULL, bt12kg DOUBLE PRECISION DEFAULT NULL, fuel DOUBLE PRECISION DEFAULT NULL, date DATETIME DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, annee VARCHAR(4) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE declinaisons (id INT AUTO_INCREMENT NOT NULL, fk_lubrifiant_id INT NOT NULL, nom VARCHAR(40) NOT NULL, grade VARCHAR(10) DEFAULT NULL, performance VARCHAR(20) DEFAULT NULL, emballage VARCHAR(20) DEFAULT NULL, fichetechnique VARCHAR(255) DEFAULT NULL, apercu VARCHAR(500) DEFAULT NULL, INDEX IDX_BA51C68AD9077592 (fk_lubrifiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lubrifiants (id INT AUTO_INCREMENT NOT NULL, lub_name VARCHAR(30) NOT NULL, lub_description VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mails (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, email VARCHAR(60) DEFAULT NULL, sujet VARCHAR(255) DEFAULT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partners (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, fk_albums_id INT NOT NULL, imagename VARCHAR(255) NOT NULL, INDEX IDX_876E0D98DE2823F (fk_albums_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stations (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, emplacement VARCHAR(255) NOT NULL, framecode VARCHAR(1000) DEFAULT NULL, bt6 VARCHAR(10) DEFAULT NULL, bt12 VARCHAR(3) DEFAULT NULL, lubs VARCHAR(255) DEFAULT NULL, cshop VARCHAR(3) DEFAULT NULL, contacts VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tlogin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(300) DEFAULT NULL, UNIQUE INDEX UNIQ_4D5BD279E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(500) NOT NULL, date DATETIME NOT NULL, thumb VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE declinaisons ADD CONSTRAINT FK_BA51C68AD9077592 FOREIGN KEY (fk_lubrifiant_id) REFERENCES lubrifiants (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D98DE2823F FOREIGN KEY (fk_albums_id) REFERENCES albums (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declinaisons DROP FOREIGN KEY FK_BA51C68AD9077592');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D98DE2823F');
        $this->addSql('DROP TABLE albums');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE boutique');
        $this->addSql('DROP TABLE carousel');
        $this->addSql('DROP TABLE couts');
        $this->addSql('DROP TABLE declinaisons');
        $this->addSql('DROP TABLE lubrifiants');
        $this->addSql('DROP TABLE mails');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE stations');
        $this->addSql('DROP TABLE tlogin');
        $this->addSql('DROP TABLE videos');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
