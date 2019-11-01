<template>
    <div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a v-if="page <= 20" class="page-link" href="#" v-on:click="getLeads('/api/leads?page='+page)">
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
            <th width="250">Комментарии</th>
            <th width="200">Подтверждение</th>
            </thead>
            <tbody>
            <tr v-for="lead in leads">
                <td>{{ lead.id }}</td>
                <td>{{ lead.name }}</td>
                <td>{{ lead.phone }}</td>
                <td>{{ sourceList[lead.type] }}</td>
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
                    <a v-if="page <= 20" class="page-link" href="#" v-on:click="getLeads('/api/leads?page='+page)">
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
                manager_id: 0
            }
        },
        props: {
            sourceList: Array,
            companies: Array,
            cities: Array
        },
        methods: {
            getLeads(url){
                let pagination;
                url = url || "/api/leads";
                axios.get(url)
                    .then(response => {
                        this.leads = response.data.data;
                        pagination = {
                            prev_page_url: response.data.links.prev,
                            next_page_url: response.data.links.next,
                            last_page_url: response.data.links.last,
                            first_page_url: response.data.links.first,
                            current_page: response.data.meta.current_page,
                            last_page: response.data.meta.last_page
                        };
                        this.pagination = pagination;
                    })
                    .catch(e => {
                        console.log(e);
                    })
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
            }
        },
        created(){
            this.leads = this.getLeads();
            this.managers = this.getManagers();
        }
    }
</script>