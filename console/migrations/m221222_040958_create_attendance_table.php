<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attendance}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%detail}}`
 */
class m221222_040958_create_attendance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attendance}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'timeIn' => $this->time()->notNull(),
            'inStatus' => $this->integer(1)->notNull(),
            'timeOut' => $this->time(),
            'outStatus' => $this->integer(1),
        ]);

        // creates index for column `detail_id`
        $this->createIndex(
            '{{%idx-attendance-detail_id}}',
            '{{%attendance}}',
            'user_id'
        );


        // add foreign key for table `{{%detail}}`
        $this->addForeignKey(
            '{{%fk-attendance-detail_id}}',
            '{{%attendance}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%detail}}`
        $this->dropForeignKey(
            '{{%fk-attendance-detail_id}}',
            '{{%attendance}}'
        );

        // drops index for column `detail_id`
        $this->dropIndex(
            '{{%idx-attendance-detail_id}}',
            '{{%attendance}}'
        );

        $this->dropTable('{{%attendance}}');
    }
}
