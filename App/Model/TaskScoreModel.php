<?php
namespace App\Model;
use \FF\Core\Model;

class TaskScoreModel extends Model{

	public function list($teacher, $id = -1) {
		$sql = '
			SELECT `t`.`id` `id`, `title`, `time`,
			FROM `task_score` `t`
			LEFT JOIN (
				SELECT `t_id`, count(`id`) `count`
				FROM `score`
				GROUP BY `task_id`
			) `s`
			ON `t`.`id` = `s`.`t_id`
			WHERE `t`.`u_id` = ' . $teacher;
		$list = $this->query($sql);
		$result['list'] = $list;
		if ($id !== -1) {
			$result['info'] = $this->get($id);
		}
		return $result;
	}

	public function get($id) {
		// $result['detail'] = model('score')->list($id);
	}

	public function delete($id) {
		
	}

}