<template>
    <div id="app">
        <div id="yearSelector">
            <select name="year" id="year" v-model="year" @change="selectYear">
                <option v-for="y in years" :value="y">{{ y }}</option>
            </select>
        </div>

        <table-component
            :data="calendar"
        >
            <table-column show="month" label="Month"></table-column>
            <table-column show="salaryDate" label="Salary Date"></table-column>
            <table-column show="bonusDate" label="Bonus Date"></table-column>
        </table-component>
    </div>
</template>

<script>
    export default {
        name: "App",

        data() {
            return {
                years: window._.range(2000, 2051),
                year: (new Date).getFullYear(),
                calendar: []
            }
        },

        mounted() {
            this.selectYear();
        },

        methods: {

            selectYear(){
                this.requestCalendar(this.year).then((data)=>{
                    this.calendar = data;
                });
            },

            async requestCalendar(year){
                const response = await axios.post('/api/calendar', {
                    year
                });

                return response.data;
            }

        }
    }
</script>

<style>

</style>
