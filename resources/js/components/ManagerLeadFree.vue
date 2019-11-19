<template>
    <div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getFreeLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a class="page-link" v-if="page <= 20" href="#" v-on:click="getFreeLeads('/manager/leads/free?page='+page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getFreeLeads(pagination.next_page_url)" href="#">Следующая</a>
                </li>
            </ul>
        </nav>
        <table class="table leads_table table-bordered table-striped">
            <thead class="thead-light">
            <th width="100">Дата</th>
            <th width="200">Подтверждение</th>
            </thead>
            <tbody>
                <tr v-for="lead in leads">
                    <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                    <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                    <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                    <td>{{ lead.comment }}</td>
                    <td>
                        <button type="button" v-on:click="getLead(lead.id)" class="btn btn-primary">Выбрать запрос</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getFreeLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="page in pagination.last_page" v-bind:class="[{ disabled: page == pagination.current_page}]">
                    <a class="page-link" v-if="page <= 20" href="#" v-on:click="getFreeLeads('/manager/leads/free?page='+page)">
                        {{ page }}
                        <span v-if="page == pagination.current_page" class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                    <a class="page-link" v-on:click="getFreeLeads(pagination.next_page_url)" href="#">Следующая</a>
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
                pagination: {}
            }
        },
        props: {
            sourceList: Array
        },
        methods: {
            getFreeLeads(url){
                let pagination;
                url = url || "/manager/leads/free";
                axios.get(url)
                    .then(response => {
                        this.leads = response.data.data;
                        console.log("asdasd",response);
                        pagination = {
                            prev_page_url: response.data.links.prev,
                            next_page_url: response.data.links.next,
                            last_page_url: response.data.links.last,
                            first_page_url: response.data.links.first,
                            current_page: response.data.meta.current_page,
                            last_page: response.data.meta.last_page
                        };
                        this.pagination = pagination;
                        console.log('page', pagination);
                    })
                    .catch(e => {
                        console.log(e);
                    })
            },
            getLead(id){
                if(confirm('Вы хотите обработать этот запрос?')){
                    axios.post('/manager/lead/'+id)
                        .then(res => {
                            console.log(res);
                            this.leads = this.getFreeLeads();
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
            }
        },
        created(){
            this.leads = this.getFreeLeads();
        }
    }
</script>