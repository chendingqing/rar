// pages/check_in/check_in.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    disabled: false,
    timeText: '短信验证码',
    currentTime: 61,
    yanzheng:"",
    phone:'',
    array: ['渝','京', '津', '沪', '蒙','新','藏','宁','桂','港','澳','黑','吉','辽','晋','冀','青','鲁','豫','苏','皖','浙','闽','赣','湘','鄂','粤','琼','甘','陕','黔','贵','滇','云','川'],
    index: 0,
    carId:"",
  },
  changeRegin: function (e) {
    console.log('e');
    // console.log(e.detail.value);
    this.setData({
      region: e.detail.value
    })
  },
  getCode: function (options) {
    var that = this;
    var currentTime = that.data.currentTime
    interval = setInterval(function () {
      currentTime--;
      that.setData({
        timeText: currentTime + '秒',
        color:"#FA810B"
      })
      if (currentTime <= 0) {
        clearInterval(interval)
        that.setData({
          timeText: '重新发送',
          currentTime: 60,
          disabled: false,
          color:"#fff"
        })
      }
    }, 1000)
  },
  getVerificationCode() {
    this.getCode();
    var that = this
    that.setData({
      disabled: true
    })
  },
  touchend:function(){
    let result=false;
    if(carId!=""){
      let id=/^[A-Z]{1}[A-Z0-9]{4}[A-Z0-9]{1}$/;
      result=id.test();
    }
    if(result==false){
      alert("车牌号有误！");
    }
    else{
      this.setData({
        carId:result
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  }
})