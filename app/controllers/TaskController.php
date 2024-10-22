<?php

namespace app\controllers;

use app\dto\TaskCreateDto;
use app\dto\TaskDto;
use app\models\Task;
use Yii;
use yii\db\Exception;
use yii\web\UnauthorizedHttpException;

class TaskController extends BaseController
{
    public $modelClass = Task::class;

    public function actions(): array
    {
        $actions = parent::actions();

        unset($actions['create']);

        return $actions;
    }

    /**
     * @throws Exception
     * @throws UnauthorizedHttpException
     */
    public function actionCreate(): array
    {
        if ($user = Yii::$app->user->identity) {
            $data = Yii::$app->request->post();
            $taskCreateDto = new TaskCreateDto($data['user_id'], $user->id, $data['title'], $data['body']);

            $task = new Task();
            $task->user_id = $taskCreateDto->user_id;
            $task->author_id = $taskCreateDto->author_id;
            $task->title = $taskCreateDto->title;
            $task->body = $taskCreateDto->body;
            $task->created_at = time();

            if ($task->validate() && $task->save()) {
                return [
                    'status' => 'success',
                    'task_id' => $task->id,
                    'message' => 'Задача создана.',
                ];
            }
        }

        throw new UnauthorizedHttpException('Пользователь не авторизован.');
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public function actionList(): array
    {
        if ($user = Yii::$app->user->identity) {
            $tasks = Task::find()->where(['user_id' => $user->getId()])->all();

            $taskList = [];

            /** @var Task $task */
            foreach ($tasks as $task) {
                $taskList[] = new TaskDto($task->id, $task->title, $task->body, $task->created_at,);
            }

            return [
                'status' => 'success',
                'data' => $taskList
            ];
        }

        throw new UnauthorizedHttpException('Пользователь не авторизован.');
    }

}
