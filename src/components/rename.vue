<template>
  <div>
    <el-row :gutter="24">
      <el-form label-position="right" label-width="90px" :inline="true">
        <el-col :span="8">
          <el-form-item :label="img">
            <el-input v-model="imgFileName"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="rename('img')">替换</el-button>
          </el-form-item>
        </el-col>
      </el-form>
    </el-row>
    <el-row :gutter="24">
      <el-form label-position="right" label-width="90px" :inline="true">
        <el-col :span="8">
          <el-form-item :label="config">
            <el-input v-model="configFileName"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="rename('config')">替换</el-button>
          </el-form-item>
        </el-col>
      </el-form>
    </el-row>
  </div>

</template>

<script>
  export default {
    name: "rename",
    data() {
      return {
        imgFileName:"",
        configFileName:"",
      }
    },
    props:["img","config"],
    methods:{
      rename(type){
        let _this=this;
        let name="";
        if(type==="img"){
          name = _this.imgFileName;
        }else {
          name = _this.configFileName;
        }
        $.post("/dist/static/php/rename.php", {type:type,newname:name}, function (res) {
          console.log(JSON.parse(res));
        });
      },
    },
  }
</script>

<style scoped>

</style>
