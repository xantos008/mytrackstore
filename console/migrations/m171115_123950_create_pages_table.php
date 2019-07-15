<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pages`.
 */
class m171115_123950_create_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
			'author_id' => $this->integer()->notNull(),
			'header_position' => $this->integer(),
            'date' => $this->integer()->notNull(),
            'category_name' => $this->text()->notNull(),
            'text' => $this->text()->notNull(),
            'title' => $this->string()->notNull()->unique(),
            'abridgment' => $this->text(),
            'meta_title' => $this->text(),
            'meta_description' => $this->text(),
            'meta_keywords' => $this->text()->notNull(),
            'activity' => $this->integer()->notNull()->defaultValue(0),
        ]
		, $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('pages');
    }
}
