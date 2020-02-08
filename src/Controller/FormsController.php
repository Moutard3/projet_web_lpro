<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Utility\Hash;

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

        $this->FormProtection->setConfig('unlockedActions', ['ajaxAnswer']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $forms = $this->paginate($this->Forms, [
            'contain' => [
                'Users',
                'StudentAnswers',
                'Questions'
            ]
        ]);

        $this->set(compact('forms'));

        return $this->render();
    }

    /**
     * View method
     *
     * @param string $id Form id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function take($id)
    {
        $form = $this->Forms->get($id, [
            'contain' => ['Questions' => ['Answers'], 'StudentAnswers'],
        ]);

        $this->set('form', $form);

        $lastAnswered = $this->Forms->StudentAnswers->find()
            ->select('question_id')
            ->where(['form_id' => $id])
            ->where(['user_id' => $this->Authentication->getIdentityData('id')])
            ->last();

        if (!isset($lastAnswered->question_id)) {
            $lastAnswered = -1;
        } else {
            $lastAnswered = $lastAnswered->question_id;
        }

        $questions = $this->Forms->Questions->find('list')
            ->select(['id'])
            ->matching('Forms', function (\Cake\ORM\Query $query) use ($id) {
                return $query->select(['id'])
                    ->where(['Forms.id' => $id]);
            })
            ->toArray();

        $nextQuestion = -1;
        foreach ($questions as $k => $v) {
            if ($k > $lastAnswered) {
                $nextQuestion = $k;
                break;
            }
        }

        if ($nextQuestion === -1) {
            return $this->redirect('/');
        }

        $question = $this->Forms->Questions->find()
            ->contain(['Answers'])
            ->matching('Forms', function (\Cake\ORM\Query $query) use ($id) {
                return $query->select(['id'])
                    ->where(['Forms.id' => $id]);
            })
            ->where(['Questions.id' => $nextQuestion])
            ->first();

        $this->set(compact('question'));

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

    public function ajaxAnswer()
    {
        $this->request->allowMethod(['post']);

        $fId = $this->request->getData('form');
        $qId = $this->request->getData('question');
        $aId = $this->request->getData('answer');

        $this->loadModel('StudentAnswers');
        $entity = $this->Forms->StudentAnswers->newEntity([
            'user_id' => $this->Authentication->getIdentity()->getIdentifier(),
            'form_id' => $fId,
            'question_id' => $qId,
            'answer_id' => $aId,
        ]);

        $alreadyAnswered = $this->Forms->StudentAnswers->find()
            ->where([
                'user_id' => $this->Authentication->getIdentity()->getIdentifier(),
                'form_id' => $fId,
                'question_id' => $qId,
            ])
            ->count();

        if (!$alreadyAnswered) {
            $this->Forms->StudentAnswers->save($entity);
            $this->set('success', 1);
        } else {
            $this->set('success', 0);
        }
    }
}
