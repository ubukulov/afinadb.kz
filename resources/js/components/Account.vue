<template>
    <div>
        <div class="content_title">
            Учетные записи менеджеров

            <button class="btn btn-primary" v-on:click="addAccount()"><i class="fas phpdebugbar-fa-edit"></i>&nbsp;Добавить учетную запись</button>
        </div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getUsers(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a class="page-link" href="#" v-on:click="getUsers('/api/users?page='+page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getUsers(pagination.next_page_url)" href="#">Следующая</a>
                </li>
            </ul>
        </nav>
        <table class="table leads_table table-bordered table-striped">
            <thead class="thead-light">
            <th width="100">#ID</th>
            <th width="100">Логин</th>
            <th width="150">Пароль</th>
            <th width="150">ФИО</th>
            <th width="150">Роль в системе</th>
            <th width="150">Статус</th>
            <th>Действие</th>
            </thead>
            <tbody>
                <tr v-for="user in users.data" v-bind:key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.password }}</td>
                    <td>{{ user.name + " " + user.last_name }}</td>
                    <td>{{ user.status }}</td>
                    <td>
                        <span v-if="user.deleted == '0'">Заблокирован</span>
                        <span v-if="user.deleted == '1'">Активно</span>
                    </td>
                    <td class="accounts_btn">
                        <button type="button" v-on:click="editAccount(user.id)"><i class="fas fa-edit"></i></button>
                        <button v-on:click="changeDeleted(user.id)" type="button"><i v-bind:class="[{ ban: user.deleted == '0' }]" class="fas fa-power-off"></i></button>
                        <button type="button"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>

        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getUsers(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a class="page-link" href="#" v-on:click="getUsers('/api/users?page='+page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getUsers(pagination.next_page_url)" href="#">Следующая</a>
                </li>
            </ul>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="modal_lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ modalTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">Имя</label>
                                    <input type="text" id="first_name" v-model="firstName" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Фамилия</label>
                                    <input type="text" id="last_name" v-model="lastName" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="username">Логин</label>
                                    <input type="text" id="username" v-model="username" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="text" id="password" v-model="password" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Роль в системе</label>
                                    <select id="type" v-model="status" class="form-control">
                                        <option value="MANAGER">MANAGER</option>
                                        <option value="TRAINEE">TRAINEE</option>
                                        <option value="CALL_CENTER">CALL_CENTER</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="company_id">Укажите компанию</label>
                                    <select id="company_id" v-model="company_id" class="form-control">
                                        <option v-for="company in companies" v-bind:key="company.id" v-bind:value="company.id">{{ company.title }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="city_id">Укажите город</label>
                                    <select id="city_id" v-model="selectedCity" class="form-control">
                                        <option v-for="city in cities" v-bind:key="city.id" v-bind:value="city.id">{{ city.title }}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="send_btn" v-on:click="editProfile ? updateAccount() : storeAccount()" class="btn btn-primary">{{ buttonTitle }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return {
                users: [],
                modalTitle: 'Редактировать профиль',
                buttonTitle: 'Изменить данные',
                id: '',
                firstName: '',
                lastName: '',
                username: '',
                password: '',
                status: '',
                city_id: 0,
                selectedCity: 0,
                company_id: 1,
                editProfile: true,
                pagination: {}
            }
        },
        props: [
            'companies',
            'cities'
        ],
        methods: {
            addAccount() {
                this.editProfile = false;
                this.modalTitle = 'Добавить учетную запись';
                this.buttonTitle = 'Добавить';
                this.firstName = '';
                this.lastName = '';
                this.username = '';
                this.password = '';
                $('#modal_lead').removeClass('fade').modal('toggle');
            },
            editAccount(id) {
                this.editProfile = true;
                this.modalTitle = 'Редактировать профиль';
                this.buttonTitle = 'Изменить данные';
                axios.get('/api/user/'+id)
                    .then(response => {
                        this.id = response.data.id;
                        this.firstName = response.data.name;
                        this.lastName = response.data.last_name;
                        this.username = response.data.email;
                        this.password = response.data.password;
                        this.status = response.data.status;
                        this.city_id = response.data.city_id;
                        this.selectedCity = response.data.city_id;
                        this.company_id = response.data.company_id;
                    })
                    .catch(e => {
                        console.log(e);
                    });
                $('#modal_lead').removeClass('fade').modal('toggle');
            },
            updateAccount(){
                axios.post('/api/user/update', {
                    'id': this.id,
                    'name': this.firstName,
                    'last_name': this.lastName,
                    'email': this.username,
                    'password': this.password,
                    'status': this.status,
                    'city_id': this.city_id,
                    'company_id': this.company_id
                })
                    .then(response => {
                        console.log(response);
                        $('#modal_lead').addClass('fade').modal('toggle');
                        this.getUsers();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            storeAccount(){
                axios.post('/api/user/create', {
                    'name': this.firstName,
                    'last_name': this.lastName,
                    'email': this.username,
                    'password': this.password,
                    'status': this.status,
                    'city_id': this.selectedCity,
                    'company_id': this.company_id
                })
                    .then(response => {
                        console.log(response);
                        $('#modal_lead').addClass('fade').modal('toggle');
                        this.getUsers();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getUsers(page_url) {
                let pagination;
                page_url = page_url || "/api/users";
                axios.get(page_url)
                    .then(response => {
                        this.users = response.data;
                        pagination = {
                            prev_page_url: response.data.prev_page_url,
                            next_page_url: response.data.next_page_url,
                            last_page_url: response.data.last_page_url,
                            first_page_url: response.data.first_page_url,
                            current_page: response.data.current_page,
                            last_page: response.data.last_page
                        };
                        this.pagination = pagination;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            changeDeleted(user_id){
                axios.post('/call_center/user/ban', {
                    user_id: user_id
                })
                    .then(res => {
                        console.log(res);
                        this.getUsers();
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },
        created() {
            this.users = this.getUsers();
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>

<style scoped>
    .ban {
        color: #ccc !important;
    }
</style>