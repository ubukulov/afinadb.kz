<template>
    <div>
        <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    <h6>Сортировка: </h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select v-model="city_id" v-on:change="getLeads()" class="form-control">
                        <option value="0">Все</option>
                        <option v-for="city in cities" v-bind:key="city.id" v-bind:value="city.id">{{ city.title }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">

            </div>
            <div class="col-md-7 text-right">
                <div class="btn-group" role="button">
                    <button v-on:click="createLeadForm()" class="btn btn-primary _create">Создать запрос</button>
                    <button class="btn btn-default _257_btn">Загрузить отчет 257.kz</button>
                    <button class="btn btn-default _chem">Загрузить отчет chemodan.kz</button>
                </div>
            </div>
        </div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a v-if="page <= 10" class="page-link" href="#" v-on:click="getLeads(page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.next_page_url)" href="#">Следующая</a>
                </li>
            </ul>
        </nav>
        <table class="table leads_table table-bordered table-striped">
            <thead class="thead-light">
            <th width="100">Дата</th>
            <th width="100">Имя</th>
            <th width="150">Тел</th>
            <th width="150">Источник</th>
            <th width="100">Город</th>
            <th width="250">Комментарии</th>
            <th width="200">Подтверждение</th>
            </thead>
            <tbody>
            <tr v-for="lead in leads">
                <td>{{ lead.id }}</td>
                <td>{{ lead.name }}</td>
                <td>{{ lead.phone }}</td>
                <td>{{ sourceList[lead.type] }}</td>
                <td>{{ cities[lead.city_id - 1].title }}</td>
                <td>{{ lead.comment }}</td>
                <td>
                    <div v-if="lead.m_type == '0'" class="status_btn">
                        <div>{{ lead.user_name + " " + lead.last_name }}</div>
                        <div class="_completed"></div>
                    </div>

                    <div v-if="lead.m_type == '2'" class="status_btn">
                        <div>{{ lead.user_name + " " + lead.last_name }}</div>
                        <div class="_canceled"></div>
                    </div>

                    <div v-if="lead.m_type == '1'" class="status_btn">
                        <div>{{ lead.user_name + " " + lead.last_name }}</div>
                        <div class="_processed"></div>
                    </div>

                    <button v-if="lead.ss == '1'" v-on:click="selectManager(lead.id)" type="button" class="btn btn-primary">Выбрать Менеджера</button>
                </td>
            </tr>
        </tbody>
        </table>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a v-if="page <= 10" class="page-link" href="#" v-on:click="getLeads(page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.next_page_url)" href="#">Следующая</a>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="manager_id">Выберите менеджера</label>
                                    <select id="manager_id" v-model="manager_id" class="form-control">
                                        <option v-for="manager in managers" v-bind:key="manager.id" v-bind:value="manager.id">
                                            {{ manager.name + " " + manager.last_name + ", " + getObjectValue(cities, manager.city_id) + ", " + getObjectValue(companies, manager.company_id) }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="send_btn" data-id="0" v-on:click="setLeadForManager()" class="btn btn-primary">Принудительно присвоить запрос</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Lead Form -->
        <div class="modal fade" id="create_lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Создать запрос</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select v-model="selectCity_id" class="form-control">
                                        <option v-for="city in cities" v-bind:key="city.id" v-bind:value="city.id">{{ city.title }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select v-model="type" class="form-control">
                                        <option v-for="(source, index) in sourceList" v-bind:key="index" v-bind:value="index">{{ source }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input v-model="first_name" type="text" class="form-control" placeholder="Имя">
                                    <span v-if="errors.first_name" class="error alert-danger">{{ errors.first_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <input v-model="email" type="email" class="form-control" placeholder="Email">
                                    <span v-if="errors.email" class="error alert-danger">{{ errors.email[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <input v-model="phone" id="phone_number" type="text" class="form-control" placeholder="Телефон">
                                    <span v-if="errors.phone" class="error alert-danger">{{ errors.phone[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <textarea v-model="comment" cols="30" rows="3" class="form-control" placeholder="Комментарий"></textarea>
                                    <span v-if="errors.comment" class="error alert-danger">{{ errors.comment[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <button v-on:click="createLead()" type="button" class="btn btn-primary">Создать запрос</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

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
                leads: [],
                managers: [],
                pagination: {},
                modalTitle: 'ВЫБЕРИТЕ МЕНЕДЖЕРА ДЛЯ ЗАПРОСА',
                manager_id: 0,
                city_id: 0,
                selectCity_id: 1,
                type: 0,
                first_name: '',
                email: '',
                phone: '',
                comment: '',
                errors: []
            }
        },
        props: {
            sourceList: Array,
            companies: Array,
            cities: Array
        },
        methods: {
            getLeads(url){
                if (this.city_id == 0) {
                    url = url || "/api/leads";
                    if (typeof url === 'number') {
                        url = "/api/leads?page="+url;
                    }
                    axios.get(url)
                        .then(response => {
                            this.leads = response.data.data;
                            this.makePagination(response.data.links, response.data.meta);
                        })
                        .catch(e => {
                            console.log(e);
                        })
                } else {
                    url = url || "/api/leads/city";
                    if (typeof url === 'number') {
                        url = "/api/leads/city?page="+url;
                    }
                    axios.post(url, {
                        city_id: this.city_id
                    })
                        .then(response => {
                            this.leads = response.data.data;
                            this.makePagination(response.data.links, response.data.meta);
                        })
                        .catch(e => {
                            console.log(e);
                        })
                }
            },
            makePagination(links, meta){
                let pagination;
                pagination = {
                    prev_page_url: links.prev,
                    next_page_url: links.next,
                    last_page_url: links.last,
                    first_page_url: links.first,
                    current_page: meta.current_page,
                    last_page: meta.last_page
                };
                this.pagination = pagination;
                console.log(pagination);
            },
            getManagers(){
                axios.get('/api/managers')
                    .then(response => {
                        this.managers = response.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },
            setLeadForManager(){
                axios.post('/call_center/manager/set/lead', {
                    lead_id: $('#send_btn').data('id'),
                    manager_id: this.manager_id,
                    _token: $("input[name='_token']").attr('content'),
                })
                    .then(res => {
                        this.getLeads();
                        $('#modal_lead').addClass('fade').modal('toggle');
                        console.log(res);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            selectManager(lead_id){
                $('#send_btn').data('id', lead_id);
                $('#modal_lead').removeClass('fade').modal('toggle');
                this.modalTitle = this.modalTitle + " #" +lead_id;
            },
            getObjectValue(object, id){
                return object.find(x => x.id === id).title;
            },
            createLeadForm(){
                $('#create_lead').removeClass('fade').modal('toggle');
            },
            createLead(){
                axios.post('/call_center/create/lead', {
                    'first_name': this.first_name,
                    'city_id': this.selectCity_id,
                    'type': this.type,
                    'email': this.email,
                    'phone': this.phone,
                    'comment': this.comment
                })
                    .then(res => {
                        $('#create_lead').addClass('fade').modal('toggle');
                        this.getLeads();
                        console.log(res);
                    })
                    .catch(err => {
                        if (err.response.status === 422) {
                            this.errors = err.response.data.errors;
                        }
                    })
            }
        },
        created(){
            this.leads = this.getLeads();
            this.managers = this.getManagers();
        }
    }
</script>
<style scoped="">
    ._chem {
        background: #853239;
        color: #fff;
    }
    ._create {
        background: #E0735E;
        border-color: #E0735E;
    }
    ._257_btn {
        background: #0099AB;
        color: #fff;
    }
</style>