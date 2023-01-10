<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%detail_group}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%detail}}`
 * - `{{%group}}`
 */
class m221222_090254_create_junction_table_for_detail_and_group_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%detail_group}}', [
            'detail_id' => $this->integer(),
            'group_id' => $this->integer(),
            'PRIMARY KEY(detail_id, group_id)',
        ]);

        // creates index for column `detail_id`
        $this->createIndex(
            '{{%idx-detail_group-detail_id}}',
            '{{%detail_group}}',
            'detail_id'
        );

        // add foreign key for table `{{%detail}}`
        $this->addForeignKey(
            '{{%fk-detail_group-detail_id}}',
            '{{%detail_group}}',
            'detail_id',
            '{{%detail}}',
            'id',
            'CASCADE'
        );

        // creates index for column `group_id`
        $this->createIndex(
            '{{%idx-detail_group-group_id}}',
            '{{%detail_group}}',
            'group_id'
        );

        // add foreign key for table `{{%group}}`
        $this->addForeignKey(
            '{{%fk-detail_group-group_id}}',
            '{{%detail_group}}',
            'group_id',
            '{{%group}}',
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
            '{{%fk-detail_group-detail_id}}',
            '{{%detail_group}}'
        );

        // drops index for column `detail_id`
        $this->dropIndex(
            '{{%idx-detail_group-detail_id}}',
            '{{%detail_group}}'
        );

        // drops foreign key for table `{{%group}}`
        $this->dropForeignKey(
            '{{%fk-detail_group-group_id}}',
            '{{%detail_group}}'
        );

        // drops index for column `group_id`
        $this->dropIndex(
            '{{%idx-detail_group-group_id}}',
            '{{%detail_group}}'
        );

        $this->dropTable('{{%detail_group}}');
    }
}
