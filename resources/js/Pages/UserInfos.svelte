<script context="module">
  import { layout, title } from '../Layouts/Layout.svelte'
</script>

<script>
  $layout = 'default'
  $title = 'User Infos'

  import { user_infos } from '@/State'
  import Table from '@/Components/Table.svelte'

  const test = [
    {
      id: 1,
      department_id: '1',
      last_name: '2',
      name: '3',
      second_name: '4',
      work_position: '5',
      mobile_phone: '6',
      phone: '7',
      login: '8',
      password: '9'
    },
    {
      id: 2,
      department_id: 'x',
      last_name: 'x',
      name: '',
      second_name: 'x',
      work_position: '',
      mobile_phone: 'x',
      phone: '',
      login: 'x',
      password: ''
    },
    {
      id: 3,
      department_id: '1',
      last_name: '2',
      name: '3',
      second_name: '4',
      work_position: '5',
      mobile_phone: '6',
      phone: '7',
      login: '8',
      password: '9'
    },
    {
      id: 4,
      department_id: 'x',
      last_name: 'x',
      name: '',
      second_name: 'x',
      work_position: '',
      mobile_phone: 'x',
      phone: '',
      login: 'x',
      password: ''
    },
    {
      id: 5,
      department_id: '1',
      last_name: '2',
      name: '3',
      second_name: '4',
      work_position: '5',
      mobile_phone: '6',
      phone: '7',
      login: '8',
      password: '9'
    },
    {
      id: 6,
      department_id: 'x',
      last_name: 'x',
      name: '',
      second_name: 'x',
      work_position: '',
      mobile_phone: 'x',
      phone: '',
      login: 'x',
      password: ''
    }
  ]
</script>

<Table data={test} />
