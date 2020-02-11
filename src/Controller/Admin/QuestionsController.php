<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Themes'],
        ];
        $questions = $this->paginate($this->Questions);

        $this->set(compact('questions'));
        return $this->render();
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Themes', 'Answers', 'Forms', 'StudentAnswers' => ['Users', 'Forms', 'Answers']],
        ]);

        $this->set('question', $question);
        return $this->render();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $question = $this->Questions->newEmptyEntity();
        if ($this->request->is('post')) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            if ($question = $this->Questions->save($question)) {
                return $this->redirect(['action' => 'edit', $question->id]);
            }
        }
        $themes = $this->Questions->Themes->find('list', ['limit' => 200]);
        $this->set(compact('question', 'themes'));
        return $this->render();
    }

    /**
     * Edit method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Answers'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            if ($this->Questions->save($question)) {
                return $this->redirect(['action' => 'index']);
            }
        }
        $themes = $this->Questions->Themes->find('list', ['limit' => 200]);
        $this->set(compact('question', 'themes'));
        return $this->render();
    }

    /**
     * Delete method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $question = $this->Questions->get($id);
        $this->Questions->delete($question);

        return $this->redirect(['action' => 'index']);
    }
}
