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
                    <button v-on:click="createLeadForm()" class="btn btn-primary _create"><i class="fas fa-edit"></i>&nbsp;Создать запрос</button>
                    <button v-on:click="openUploadFileForm()" class="btn btn-default _257_btn"><i class="fas fa-upload"></i>&nbsp;Загрузить отчет</button>
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
            <th width="100">Компания</th>
            </thead>
            <tbody>
            <tr v-for="lead in leads">
                <td v-if="lead.dn == 0">{{ lead.dt + " #" + lead.id + " (сегодня)"  }}</td>
                <td v-else-if="lead.dn == 1">{{ lead.dt + " #" + lead.id + " (вчера)" }}</td>
                <td v-else="lead.dn > 1">{{ lead.dt + " #" + lead.id + " (" + lead.dn + ") дней"  }}</td>
                <td>{{ lead.name }}</td>
                <td>{{ lead.phone }}</td>
                <td v-if="lead.type_app == 1" v-bind:class="setClassName(lead.type)">
                    {{ sourceList[lead.type] }} - Whats'App
                </td>
                <td v-if="lead.type_app == 2" v-bind:class="setClassName(lead.type)">
                    {{ sourceList[lead.type] }} - JivoSite
                </td>
                <td v-if="lead.type_app == 0" v-bind:class="setClassName(lead.type)">
                    {{ sourceList[lead.type] }}
                </td>
                <td>{{ cities[lead.city_id - 1].title }}</td>
                <td>
                    {{ lead.comment }}
                </td>
                <td>
                    <div v-if="lead.m_type == '0'" class="status_btn">
                        <div v-bind:title="lead.com_title" v-bind:style="[lead.is_called == 1 ? {'background': 'red'} : '']">{{ lead.user_name + " " + lead.last_name }}</div>
                        <div class="_completed"></div>
                    </div>

                    <div v-if="lead.m_type == '2'" class="status_btn">
                        <div v-bind:title="lead.com_title" v-bind:style="[lead.is_called == 1 ? {'background': 'red'} : '']">{{ lead.user_name + " " + lead.last_name }}</div>
                        <div class="_canceled"></div>
                    </div>

                    <div v-if="lead.m_type == '1'" class="status_btn">
                        <div v-bind:title="lead.com_title" v-bind:style="[lead.is_called == 1 ? {'background': 'red'} : '']">{{ lead.user_name + " " + lead.last_name }}</div>
                        <div class="_processed"></div>
                    </div>

                    <button v-if="lead.ss == '1'" v-on:click="selectManager(lead.id)" type="button" class="btn btn-primary"><i class="fas fa-user-check"></i></button>
                </td>
                <td v-if="lead.company == '0'" class="_chem">
                    chemodan.kz
                </td>
                <td v-if="lead.company == '1'" class="_257_btn">
                    257.kz
                </td>
                <td v-if="lead.company == '2'" class="_pcvp">
                    ТОО "ПЦВП"
                </td>
            </tr>
        </tbody>
        </table>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                    <a class="page-link" v-on:click="getLeads(pagination.prev_page_url)" href="#" tabindex="-1">Предыдущая</a>
                </li>
                <li class="page-item" v-for="p in pagination.last_page" v-bind:class="[{ disabled: p == pagination.current_page}]">
                    <a v-if="p <= 10" class="page-link" href="#" v-on:click="getLeads(p)">
                        {{ p }}
                        <span v-if="p == pagination.current_page" class="sr-only">(current)</span>
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
                                            {{ manager.name + " " + manager.last_name + ", " + manager.c_title + ", " + manager.com_title + ", " + manager.status }}
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
                                    <select v-model="company_id" class="form-control">
                                        <option value="0">Чемодан</option>
                                        <option value="1">257</option>
                                        <option value="2">ПЦВП</option>
                                    </select>
                                </div>
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
                                    <select v-model="type_app" class="form-control">
                                        <option value="0">-</option>
                                        <option value="1">Whats'App</option>
                                        <option value="2">JivoSite</option>
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
                                    <input v-model="phone" type="text" class="form-control" placeholder="Телефон">
                                    <span v-if="errors.phone" class="error alert-danger">{{ errors.phone[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <textarea v-model="comment" cols="30" rows="3" class="form-control" placeholder="Комментарий"></textarea>
                                    <span v-if="errors.comment" class="error alert-danger">{{ errors.comment[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <button v-on:click="createLead()" type="button" class="btn btn-primary"><i class="fas fa-edit"></i>&nbsp;Создать запрос</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

        <!-- Upload File Form -->
        <div class="modal fade" id="upload_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Форма загрузки лиды от Facebook</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div v-if="success != ''" class="alert alert-success" role="alert">
                                    {{success}}
                                </div>
                                <form v-on:submit="formSubmit" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <select v-model="fbcompany_id" class="form-control">
                                            <option value="0">chemodan.kz</option>
                                            <option value="1">257.kz</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select v-model="fbcity_id" class="form-control">
                                            <option value="1">Алматы</option>
                                            <option value="2">Нур-Султан</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" v-on:change="onFileChange" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary">Отправить лиды</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                company_id: 0,
                city_id: 0,
                selectCity_id: 1,
                type: 0,
                first_name: '',
                email: '',
                phone: '',
                comment: '',
                errors: [],
                file: '',
                success: '',
                fbcity_id: 1,
                fbcompany_id: 0,
                type_app: 0,
                class_list: ['Website','Instagram', 'Facebook','Whatsapp','chemodan','257','turkish','alanya','Website','Website','Website','Website','Website','Website','mardan', 'egipt', 'emirat', 'turkish', 'alanya', 'egipt', 'emirat', 'tailand', 'tailand', 'hainan', 'hainan', 'goa', 'goa']
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
                    'comment': this.comment,
                    'company': this.company_id,
                    'type_app': this.type_app
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
            },
            onFileChange(e){
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('city_id', this.fbcity_id);
                formData.append('company_id', this.fbcompany_id);

                axios.post('/call_center/lead/file', formData, config)
                    .then(res => {
                        console.log(res);
                        this.getLeads();
                        $('#upload_file').addClass('fade').modal('toggle');
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            openUploadFileForm(){
                $('#upload_file').removeClass('fade').modal('toggle');
            },
            setClassName(index){
                if (index > 26 && index < 36) {
                    return 'Whatsapp';
                } else if (index > 35 && index < 45) {
                    return 'Website';
                } else if (index == 45 || index == 46){
                    return 'dubai';
                } else if (index == 47 || index == 48){
                    return 'abu_dhabi';
                } else if (index == 49 || index == 50){
                    return 'sharjah';
                } else if (index == 51 || index == 52){
                    return 'rah';
                } else if (index == 53 || index == 54){
                    return 'fujairah';
                } else if (index > 54 && index < 60) {
                    return 'Whatsapp';
                } else if (index > 59 && index < 65) {
                    return 'Whatsapp';
                } else if (index > 64 && index < 67) {
                    return 'dominicana';
                } else if(index == 67){
                    return 'fr';
                } else if (index == 70 || index == 71){
                    return 'maldiv';
                } else if (index == 72) {
                    return 'Whatsapp';
                } else if (index == 74) {
                    return 'education';
                } else {
                    return this.class_list[index];
                }
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
    ._pcvp {
        background: #323544;
        color: #fff;
    }
    .Website, .chemodan {background: yellow;}
    ._257 {background: #a95959;}
    .turkish {background: #caf2ff;}
    .alanya {background: green; color: white;}
    .mardan {background: teal; color: white;}
    .egipt {background: #F1B47D; color: black;}
    .emirat {background: #FF7F50; color: white;}
    .tailand {background: #2974AD; color: white;}
    .hainan {background: #874AEF; color: white;}
    .goa {background: #17B796; color: white;}
    .dubai {background: #5C3504; color: white;}
    .abu_dhabi {background: #34AF98; color: white;}
    .sharjah {background: #4683C3; color: white;}
    .rah {background: #750F7E; color: white;}
    .fujairah {background: #5C3BA5; color: white;}
    .dominicana {background: #002D62; color: white;}
    .fr {background: #853239; color: white;}
    .maldiv {background: #007E3A; color: white;}
    .Instagram {
        background: #ff5876;
        color: white;
    }
    .Facebook {
        background: #339ac3;
        color: white;
    }
    .Whatsapp {
        background: #afffaf;
    }
    .education {
        background: #C950AD; color: #fff;
    }
</style>