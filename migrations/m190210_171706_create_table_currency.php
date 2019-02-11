<?php

use yii\db\Migration;

class m190210_171706_create_table_currency extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey()->unsigned()->comment('Идентификатор записи'),
            'name' => $this->string()->notNull()->comment('Название валюты'),
            'rate' => $this->decimal(7, 4)->unsigned()->notNull()->comment('Курс по отношению к рублю'),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%currency}}');
    }
}
