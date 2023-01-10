<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%department}}`
 */
class m221221_082404_create_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'department_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `department_id`
        $this->createIndex(
            '{{%idx-group-department_id}}',
            '{{%group}}',
            'department_id'
        );

        // add foreign key for table `{{%department}}`
        $this->addForeignKey(
            '{{%fk-group-department_id}}',
            '{{%group}}',
            'department_id',
            '{{%department}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%department}}`
        $this->dropForeignKey(
            '{{%fk-group-department_id}}',
            '{{%group}}'
        );

        // drops index for column `department_id`
        $this->dropIndex(
            '{{%idx-group-department_id}}',
            '{{%group}}'
        );

        $this->dropTable('{{%group}}');
    }
}
