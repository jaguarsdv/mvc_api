<?php

namespace src\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillProductTable extends Command
{
    protected function configure()
    {
        $this
            ->setName('db:add-products')
            ->setAliases(['add-products'])
            ->setDescription('Заполняет таблицу `product` данными');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sql = <<<SQL
INSERT IGNORE INTO `product` (`id`, `name`, `price`, `create_date`, `update_date`)
VALUES
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143001', 'Товар1', 100.58, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143002', 'Товар2', 760.22, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143003', 'Товар3', 50, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143004', 'Товар4', 176.74, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143005', 'Товар5', 1520.99, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143006', 'Товар6', 999.99, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143007', 'Товар7', 777.77, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143008', 'Товар8', 104.75, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143009', 'Товар9', 220.90, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143010', 'Товар10', 86.44, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143011', 'Товар11', 1100.7, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143012', 'Товар12', 667.33, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143013', 'Товар13', 256.64, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143014', 'Товар14', 128.32, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143015', 'Товар15', 391.24, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143016', 'Товар16', 170.58, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143017', 'Товар17', 345.81, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143018', 'Товар18', 515.06, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143019', 'Товар19', 827.88, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143020', 'Товар20', 305.35, 1562493944, 1562493944)
SQL;
        /** @var \Doctrine\DBAL\Connection */
        $connection = $this->getHelperSet()->get('db')->getConnection();
        $connection->prepare($sql)->execute();
    }
}
