<?php
declare(strict_types=1);

namespace App\Controller;

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
            'contain' => ['FormsQuestions', 'StudentAnswers', 'StudentResults', 'Users'],
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
}
