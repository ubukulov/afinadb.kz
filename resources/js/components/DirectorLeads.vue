<template>
    <div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a v-if="page <= 10" class="page-link" href="#" v-on:click="getLeads('/director/leads/list?page='+page)">
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
            <th width="100">Город</th>
            <th width="100">Источник</th>
            <th width="200">Подтверждение</th>
            </thead>
            <tbody>
            <tr v-for="(lead, index) in leads">
                <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                <td>
                    {{ lead.c_title }}
                </td>
                <td v-if="lead.type_app == 1" v-bind:class="setClassName(lead.type)">
                    {{ sourceList[lead.type] }} - Whats'App
                </td>
                <td v-if="lead.type_app == 2" v-bind:class="setClassName(lead.type)">
                    {{ sourceList[lead.type] }} - JivoSite
                </td>
                <td v-if="lead.type_app == 0" v-bind:class="setClassName(lead.type)">
                    {{ sourceList[lead.type] }}
                </td>
                <td v-if="index == 0">
                    <button type="button" v-on:click="getLead(lead.id)" class="btn btn-primary">Выбрать запрос</button>
                </td>
                <td v-else="index != 0">
                    <button type="button" class="btn btn-primary disabled">Выбрать запрос</button>
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
                    <a v-if="page <= 10" class="page-link" href="#" v-on:click="getLeads('/director/leads/list?page='+page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.next_page_url)" href="#">Следующая</a>
                </li>
            </ul>
        </nav>
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
                city_id: 0
            }
        },
        props: {
            sourceList: Array,
            companies: Array,
            cities: Array
        },
        methods: {
            getLeads(url){
                url = url || "/director/leads/list";
                axios.get(url)
                    .then(response => {
                        this.leads = response.data.data;
                        this.makePagination(response.data.links, response.data.meta);
                    })
                    .catch(e => {
                        console.log(e);
                    })
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
            getLead(id){
                if(confirm('Вы хотите обработать этот запрос?')){
                    axios.post('/manager/lead/'+id)
                        .then(res => {
                            console.log(res);
                            this.leads = this.getLeads();
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            }
        },
        created(){
            this.leads = this.getLeads();
            this.managers = this.getManagers();
        }
    }
</script>