<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;

/**
 * Forms Controller
 *
 * @property \App\Model\Table\FormsTable $Forms
 *
 * @method \App\Model\Entity\Form[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FormsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->FormProtection->setConfig('unlockedActions', ['addQuestion', 'deleteQuestion']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $forms = $this->paginate($this->Forms, ['contain' => 'Users']);

        $this->set(compact('forms'));

        return $this->render();
    }

    /**
     * View method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $form = $this->Forms->get($id, [
            'contain' => ['Questions', 'StudentAnswers', 'StudentResults', 'Users'],
        ]);

        $this->set('form', $form);

        return $this->render();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $form = $this->Forms->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['created_by'] = $this->Authentication->getIdentityData('id');
            $form = $this->Forms->patchEntity($form, $data);
            if ($this->Forms->save($form)) {
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erreur');
        }
        $this->set(compact('form'));

        return $this->render();
    }

    /**
     * Edit method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $form = $this->Forms->get($id, [
            'contain' => ['Questions'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $form = $this->Forms->patchEntity($form, $this->request->getData());
            if ($this->Forms->save($form)) {
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erreur');
        }
        $questions = $this->Forms->Questions->find('list', ['order' => 'theme_id'])->toArray();
        $this->set(compact('form', 'questions'));

        return $this->render();
    }

    /**
     * Delete method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $form = $this->Forms->get($id);
        if (!$this->Forms->delete($form)) {
            $this->Flash->error('Erreur');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function addQuestion()
    {
        $this->request->allowMethod(['post']);

        $form = $this->Forms->get($this->request->getData('form_id'), [
            'contain' => ['Questions']
        ]);


        $data = [];
        $data['questions'] = [];
        $data['questions']['_ids'] = [];

        foreach ($form->questions as $q) {
            $data['questions']['_ids'][] = $q->id;
        }

        $error = 0;

        if (in_array($this->request->getData('question_id'), $data['questions']['_ids'])) {
            $message = "Cette question est déjà dans ce QCM.";
            $error = 2;
        }

        $data['questions']['_ids'][] = $this->request->getData('question_id');

        $form = $this->Forms->patchEntity($form, $data, [
            'associated' => ['Questions']
        ]);
        if ($error == 0 && $this->Forms->save($form)) {
            $message = "Succès.";
        } else if ($error == 0) {
            $message = "Erreur.";
            $error = 1;
        }

        $question = $this->Forms->Questions->find()
            ->where(['id' => $this->request->getData('question_id')])
            ->first();
        $this->set(compact('error', 'message', 'question'));
    }

    public function deleteQuestion()
    {
        $this->request->allowMethod(['post']);

        $form = $this->Forms->get($this->request->getData('form_id'), [
            'contain' => ['Questions']
        ]);

        $data = [];
        $data['questions'] = [];
        $data['questions']['_ids'] = [];

        foreach ($form->questions as $q) {
            if ($q->id != $this->request->getData('question_id'))
                $data['questions']['_ids'][] = $q->id;
        }

        $error = 0;

        $form = $this->Forms->patchEntity($form, $data, [
            'associated' => ['Questions']
        ]);
        if ($error == 0 && $this->Forms->save($form)) {
            $message = "Succès.";
        } else if ($error == 0) {
            $message = "Erreur.";
            $error = 1;
        }

        $this->set(compact('error', 'message'));
    }
}
