<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;

/**
 * Answers Controller
 *
 * @property \App\Model\Table\AnswersTable $Answers
 *
 * @method \App\Model\Entity\Answer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnswersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->FormProtection->setConfig('unlockedActions', ['add', 'edit', 'delete', 'toggleValid']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Questions'],
        ];
        $answers = $this->paginate($this->Answers);

        $this->set(compact('answers'));
        return $this->render();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        $answer = $this->Answers->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = [];
            $data['valid'] = 0;
            $data['display_text'] = $this->request->getData('answer');
            $data['feedback'] = $this->request->getData('feedback');
            $data['question_id'] = $this->request->getData('question_id');
            $answer = $this->Answers->patchEntity($answer, $data);
            if ($this->Answers->save($answer)) {
                $message = "La reponse a bien été ajoutée.";
                $error = 0;
            } else {
                $message = "Une erreur est survenue lors de l'ajout de la réponse.";
                $error = 1;
            }
        }
        $this->set(compact('message', 'error', 'answer'));
        return $this->render();
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $id = $this->request->getData('answer_id');
            $data = [];
            $data['display_text'] = $this->request->getData('answer');
            $data['feedback'] = $this->request->getData('feedback');

            $answer = $this->Answers->get($id, [
                'contain' => [],
            ]);
            $answer = $this->Answers->patchEntity($answer, $data);

            if ($this->Answers->save($answer)) {
                $message = 'La réponse a été sauvegardée';
                $error = 0;
            } else {
                $message = "Une erreur est survenue lors de la sauvegarde de la réponse.";
                $error = 1;
            }
        }
        $this->set(compact('answer', 'error', 'message'));
        return $this->render();
    }

    /**
     * Delete method
     *
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);

        $id = $this->request->getData('answer_id');
        $answer = $this->Answers->get($id);
        if ($this->Answers->delete($answer)) {
            $message = 'Succès';
            $error = 0;
        } else {
            $message = 'Erreur';
            $error = 1;
        }

        $this->set(compact('message', 'error'));
        return $this->render();
    }

    /**
     * Toggle valid answer method
     *
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function toggleValid()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $answer_id = $this->request->getData('answer_id');
            $data = [];

            $answer = $this->Answers->get($answer_id, [
                'contain' => [],
            ]);
            $data['valid'] = !$answer->valid;
            $answer = $this->Answers->patchEntity($answer, $data);

            // Pour une seule bonne réponse possible
//            $oldAnswer = $this->Answers->find()
//                ->where(['valid' => 1])
//                ->where(['question_id' => $question_id])
//                ->first();
//            if (!empty($oldAnswer)) {
//                $oldAnswer->set('valid', 0);
//                $this->Answers->save($oldAnswer);
//            }

            if ($this->Answers->save($answer)) {
                $message = 'Succès';
                $error = 0;
            } else {
                $message = "Erreur";
                $error = 1;
            }
        }
        $this->set(compact('answer', 'error', 'message'));
        return $this->render();
    }
}
