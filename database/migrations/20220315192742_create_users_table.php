<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('users')
            ->addColumn('uuid','string')
            ->addColumn('name','string')
            ->addColumn('pseudo','string')
            ->addColumn('email','string')
            ->addColumn('password','string')
            ->addColumn('profil','string')
            ->addColumn('created_at','datetime')
            ->addColumn('update_at','datetime', [
                'null' => true
            ])
            ->create();
    }
}
