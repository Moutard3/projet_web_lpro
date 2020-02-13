<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;
use Cake\ORM\Query;

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

        $this->FormProtection->setConfig('unlockedActions', ['addQuestion', 'deleteQuestion', 'getQuestionsByTheme']);
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
            'contain' => ['Questions' => ['Answers'], 'StudentAnswers', 'StudentResults', 'Users'],
        ]);

        $users_done = $this->Forms->Users->find()
            ->contain(['StudentResults'])
            ->matching('StudentAnswers', function (Query $builder) use ($id) {
                return $builder->where(['StudentAnswers.form_id' => $id]);
            })
            ->all();

//        debug($users_done);

        $this->set('users_done', $users_done);
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
        $themes = $this->Forms->Questions->Themes->find('list', ['order' => 'display_name'])->toArray();
        $this->set(compact('form', 'questions', 'themes'));

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

    public function computeResults($id)
    {
        $this->request->allowMethod('POST');

        $this->loadModel('StudentAnswers');
        $form = $this->StudentAnswers->find()
            ->select(['StudentAnswers.user_id', 'Answers.valid'])
            ->contain('Answers')
            ->where(['form_id' => $id])
            ->toArray();

        $nbQuestions = $this->Forms->Questions->find()
            ->matching('Forms', function (Query $builder) use ($id) {
                return $builder->where(['Forms.id' => $id]);
            })
            ->count();

        $results = [];
        foreach ($form as $v) {
            $results[$v['user_id']][] = $v['answer']['valid'];
        }

        $this->loadModel('StudentResults');
        foreach ($results as $user_id => $answers) {
            $results[$user_id] = round(count(array_filter($results[$user_id])) * 20 / $nbQuestions, 2, PHP_ROUND_HALF_UP);

            $entity = $this->StudentResults->newEntity([
                'user_id' => $user_id,
                'form_id' => $id,
                'result'  => $results[$user_id],
                'published' => 0,
            ]);
            $this->StudentResults->save($entity);
        }

        return $this->redirect($this->referer());
    }

    public function publishResults($id)
    {
        $this->request->allowMethod('POST');

        $this->loadModel('StudentResults');
        $this->computeResults($id);
        $this->StudentResults->updateAll([
            'published' => 1
        ], [
            'form_id' => $id
        ]);

        return $this->redirect($this->referer());
    }

    public function getQuestionsByTheme()
    {
        $this->request->allowMethod(['post']);
        $theme_id = $this->request->getData('theme_id');

        $message = 'Vous devez fournir le theme_id';
        $error = 1;
        if (isset($theme_id)) {
            $message = 'Succès.';
            $error = 0;
        }

        $questions = $this->Forms->Questions->find('list')
            ->where(['theme_id' => $theme_id]);

        $this->set(compact('error', 'message', 'questions'));
    }
}
