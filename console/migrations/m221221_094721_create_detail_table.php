<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%detail}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m221221_094721_create_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%detail}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'email' => $this->string(),
            'phoneNumber' => $this->string(11),
            'user_id' => $this->integer()->notNull(),
            'department_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-detail-user_id}}',
            '{{%detail}}',
            'user_id'
        );

        //
        $this->createIndex(
            '{{%idx-detail-department_id}}',
            '{{%detail}}',
            'department_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-detail-user_id}}',
            '{{%detail}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-detail-department_id}}',
            '{{%detail}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-detail-user_id}}',
            '{{%detail}}'
        );

        $this->dropForeignKey(
            '{{%fk-detail-department_id}}',
            '{{%detail}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-detail-user_id}}',
            '{{%detail}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-detail-department_id}}',
            '{{%detail}}'
        );

        $this->dropTable('{{%detail}}');
    }
}
