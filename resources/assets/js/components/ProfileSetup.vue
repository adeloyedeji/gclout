<template>
    <div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <span class="text-center">VITAL PROFILE UPDATE.</span>
                    </div>
                </div>
                <div class="panel no-margin">
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3">
                            <form class="form floating-label" role="form">
                                <div class="form-group">
                                    <label class="control-label">Sex</label>
                                    <div class="control-group">
                                        <div class="radio">
                                            <label>
                                                <input name="inlineRadioOptions" id="male" type="radio" class="colored-blue" value="1" checked="checked">
                                                <span class="text"> Male&nbsp;&nbsp;</span>
                                            </label>
                                            <label>
                                                <input name="inlineRadioOptions" id="female" type="radio" class="colored-blue" value="2">
                                                <span class="text"> Female</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <p></p>
                                <div class="form-group">
                                    <label class="control-label" for="username">Username</label>
                                    <input class="form-control" type="text" id="username" name="username" v-model="username" value="">
                                </div>
                                <label class="red" id="chk" v-if="disabled">{{ check_username }}</label>
                                <label class="green" id="chk" v-else>{{ check_username }}</label>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label" for="dob">Date of Birth (Year | Month | Day)</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="dob" name="dob">
                                            <option value="0">Year of birth</option>
                                            <option v-for="year in year_of_birth" :value="year">{{ year }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="month" name="month" v-model="month">
                                            <option value="00">Month</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="day" name="day">
                                            <option value="00">Day</option>
                                            <option v-for="day in days" :value="day">{{ day }}</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label" for="nationality">Nationality</label>
                                    <select class="form-control" id="nationality" name="nationality" v-model="nationality">
                                        <option v-for="(country, index) in countries" :value="index+1">{{ country }}</option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label" for="residence">
                                    Current country of residence
                                    </label>
                                    <select class="form-control" id="residence" name="residence" v-model="residence">
                                        <option v-for="(country, index) in countries" :value="index+1">{{ country }}</option>
                                    </select>
                                </div>
                                <br>
                                <div class="row" id="tiwatiwa" :class="origin">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="state">State</label>
                                        <select class="form-control select2-list" data-placeholder="Select your state" id="state" name="state" v-model="state_origin">
                                            <option value="0">State of residence</option>
                                            <option v-for="(state, index) in states" :value="index+1">{{ state }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="lga">LGA</label>
                                        <select class="form-control select2-list" data-placeholder="Select your LGA" id="lga" name="lga">
                                            <option value="0">Your LGA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <button class="btn btn-block ink-reaction btn-primary" id="submit-profile" :disabled="disabled" @click.prevent="update_profile">Continue</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="space">

        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.get_countries()
        this.get_states()
        this.set_years()
    },
    data() {
        return {
            countries: [],
            states: [],
            lga_origin: [],
            year_of_birth: [],
            month: ['Month'],
            nationality: '',
            residence: '',
            username: '',
            disabled: false,
            state_origin: '',
        }
    }, 
    methods: {
        get_countries() {
            axios.get('/get_countries/all')
                 .then( (resp) => {
                     resp.data.forEach( (c) => {
                         this.countries.push(c.country)
                     } )
                 } ) 
        }, 
        get_states() {
            axios.get('/get_states/all')
                 .then( (resp) => {
                     resp.data.forEach( (s) => {
                         this.states.push(s.state)
                     } )
                 } ) 
        }, 
        set_years() {
            for(var i = 1990; i <= 2000; i++) {
                this.year_of_birth.push(i)
            }
        }, 
        notify(type, msg) {
            new Noty({
                type: type,
                layout: 'bottomLeft',
                text: msg
            }).show();
        },
        update_profile() {
            this.disabled = true
            var gender
            if(document.getElementById("male").checked) {
                gender = document.getElementById("male").value
            } else {
                gender = document.getElementById("female").value
            }
            var username = this.username
            var dob = document.getElementById("dob").value + "-" + document.getElementById("month").value + "-" + document.getElementById("day").value
            console.log(dob)
            var nationality = document.getElementById("nationality").value
            var residence = document.getElementById("residence").value
            var state = document.getElementById("state").value ? document.getElementById("state").value : 0
            var origin = document.getElementById("lga").value ? document.getElementById("lga").value : 0
            axios.post("/profile/update/intro", {
                gender: gender, 
                username: username, 
                dob: dob,
                nationality: nationality, 
                residence: residence, 
                state: state, 
                lga: origin,
            })
            .then( (resp) => {
                console.log(resp)
                console.log(resp.data)
                if(resp.data == "success") {
                    this.notify('success', 'Profile update successful.')
                    window.location = "/intro/know-your-leaders"
                } else {
                    if(resp.data.username) {
                        this.notify('error', 'Invalid or already existing username')
                    }
                    if(resp.data.dob) {
                        this.notify('error', 'Invalid date of birth')
                    }
                    if(resp.data.nationality) {
                        this.notify('error', 'Select a valid nationality')
                    }
                    if(resp.data.residence) {
                        this.notify('error', 'Select a valid country of residence')
                    }
                    if(resp.data.state) {
                        this.notify('error', 'Select a valid state')
                    }
                    if(resp.data.lga) {
                        this.notify('error', 'Select a valid local government area')
                    }
                }
            })
            this.disabled = false
        }
    }, 
    computed: {
        origin() {
            var nation = this.nationality
            var reside = this.residence
            if(nation == 149 || reside == 149) {
                return "show"
            } else {
                return "hide"
            }
        },
        days() {
            var months_of_birth = []
            if(this.month == 9 || this.month == 4 || this.month == 6 || this.month == 11) {
                for(var i = 1; i <= 30; i++) {
                    months_of_birth.push(i)
                }
            } else if(this.month == '02') {
                for(var i = 1; i <= 28; i++) {
                    months_of_birth.push(i)
                }
            } else {
                for(var i = 1; i <= 31; i++) {
                    months_of_birth.push(i)
                }
            }
            return months_of_birth
        }, 
        check_username() {
            if(this.username.length > 0) {
                var status = "";
                var user = this.username.replace(" ", ".")
                axios.get('/get_username/' + user)
                    .then( (resp) => {
                        if(resp.data == "available") {
                            document.getElementById("chk").innerHTML = user + " is available"
                            this.disabled = false
                        } else {
                            document.getElementById("chk").innerHTML = user + " is not available"
                            this.disabled = true
                        }
                    } )
            }
        }, 
        lgas() {
            var state = '', length
            var lga = []
            if(this.state_origin != 0) {
                axios.get('/get_lgas/bystate/' + this.state_origin)
                    .then( (resp) => {
                        resp.data.forEach( (l) => {
                            lga.splice(l.id, 0, l.lga)
                        } )
                        this.lga_origin = lga
                        length = resp.data.length
                        state = resp.data[0].state.state
                    } )
                    /*
                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'We found ' + length + " local government areas within " + state + " state!"
                }).show();
                */
            }
            return this.lga_origin
        }
    }
}
</script>
<style>
    #space {
        height: 50px;
    }
    .red {
        color:rgb(182, 54, 54);
    }
    .green {
        color:rgb(17, 182, 182);
    }
    .show {
        display: block;
    }
    .hide {
        display: none;
    }
</style>
