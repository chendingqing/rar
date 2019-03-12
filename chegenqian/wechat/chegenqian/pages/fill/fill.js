// pages/fill/fill.js
var interval = null;
Page({
  data: {
    array: ['渝', '京', '津', '沪', '蒙', '新', '藏', '宁', '桂', '港', '澳', '黑', '吉', '辽', '晋', '冀', '青', '鲁', '豫', '苏', '皖', '浙', '闽', '赣', '湘', '鄂', '粤', '琼', '甘', '陕', '黔', '贵', '滇', '云', '川'],
    index: 0,
    carId: '',
    name: '',
    phone: '',
    region: ["上海市", "上海市", "黄浦区"],
    site_det: "",
    moneyNum: 30,
    yanzheng: "",
    disabled: false,
    timeText: '获取验证码',
    currentTime: 60,
    color: "#fff",
    show1: "display:none",
    show2: "display:none",
    defaultText: "请选择区域",
    address: '',
    style: 'background-color:#FA810B',
    text: "",
    code_status: true
  },
  // 选择车牌简称
  bindPickerChange: function(e) {
    this.setData({
      index: e.detail.value
    })
  },
  // 选择省市区函数
  changeRegin: function(e) {
    console.log(e.detail.value);
    let addressDetails = e.detail.value[0] + '-' + e.detail.value[1] + '-' + e.detail.value[2];
    this.setData({
      address: addressDetails
    })
  },
  //验证 定时器
  getCode: function(options) {
    let that = this;
    let currentTime = that.data.currentTime;
    let code_status = that.data.code_status;
    if (!code_status) {
      return;
    }
    that.setData({
      timeText: currentTime + '秒',
      color: "#999",
      currentTime: currentTime,
      code_status: false
    })
    let interval = setInterval(function() {
      currentTime--;
      console.log(currentTime);
      that.setData({
        timeText: currentTime + '秒',
        currentTime: currentTime,
      })
      if (currentTime < 1) {
        clearInterval(interval)
        that.setData({
          timeText: '重新发送',
          currentTime: 60,
          disabled: false,
          color: "#fff",
          style: "background-color:#FA810B;",
          code_status: true,
        })
      }
    }, 1000)
},
alert_btn() {
    this.setData({
      show1: "display:none"
    })
  },
  getVerificationCode() {
    let that = this
    let time = that.data.currentTime;
    if (time != 60) {
      return;
    }
    let code_status = that.data.code_status;
    if (!code_status) {
      return;
    }
    this.getCode();

    that.setData({
      disabled: true,
      style: "background-color:#dedede;"
    })
  },
  //底部判断事件
  // 点击立即购买
  getCarId(e) {
    this.setData({
      carId: e.detail.value
    })
  },
  getPhone(e) {
    this.setData({
      phone: e.detail.value
    })
  },
  getuserName(e) {
    this.setData({
      name: e.detail.value
    })
  },
  getAddress(e) {
    this.setData({
      address: e.detail.value
    })
  },
  getSite(e) {
    this.setData({
      site_det: e.detail.value
    })
  },
  getyanzheng(e){
    this.setData({
      yanzheng: e.detail.value
    })
  },
  lastCheck(e) {
    //车牌号判断
    if (this.data.carId.length != 6) {
      wx.showModal({
        content: '请输入正确的车牌号',
        success(res) {
          if (res.confirm) {
            console.log('用户点击确定')
          } else if (res.cancel) {
            console.log('用户点击取消')
          }
        }
      })
      return;
    } else {
      let RegExps = new RegExp(/^[A-Z]{1}[A-Z0-9]{4}[A-Z0-9]{1}$/);
      let hasOk = RegExps.exec(this.data.carId);
      if (hasOk) {
        console.log('符合标准');
      } else {
        wx.showModal({
          content: '请输入正确的车牌号',
          success(res) {
            if (res.confirm) {
              console.log('用户点击确定')
            } else if (res.cancel) {
              console.log('用户点击取消')
            }
          }
        })
      }
    }
    // 电话判断
    if (this.data.phone.length != 11) {
      wx.showModal({
        content: '请输入正确的电话号码',
        success(res) {
          if (res.confirm) {
            console.log('用户点击确定')
          } else if (res.cancel) {
            console.log('用户点击取消')
          }
        }
      })
      return;
    } else {
      let RegExps = new RegExp(/^[1][3,4,5,7,8][0-9]{9}$/);
      let hasOk = RegExps.exec(this.data.phone);
      if (hasOk) {
        console.log('符合标准');
      } else {
        wx.showModal({
          content: '请输入正确的车牌号',
          success(res) {
            if (res.confirm) {
              console.log('用户点击确定')
            } else if (res.cancel) {
              console.log('用户点击取消')
            }
          }
        })
        return;
      }
    }
    //验证码判断
    if(this.data.yanzheng.length==0){
      wx.showModal({
        content:"验证码不能为空",
      })
      return;
    }
    //姓名判断 不能为数字
    if (this.data.name.length == 0) {
      wx.showModal({
        content: "姓名不能为空",
        success(res) {
          if (res.confirm) {
            console.log('用户点击确定')
          } else if (res.cancel) {
            console.log('用户点击取消')
          }
        }
      })
      return;
    } else {
      if (isNaN(this.data.name)) {
        console.log("1" + isNaN(this.data.name) + this.data.name);
      } else {
        wx.showModal({
          content: "请输入正确的姓名",
          success(res) {
            if (res.confirm) {
              console.log('用户点击确定')
            } else if (res.cancel) {
              console.log('用户点击取消')
            }
          }
        })
        return;
      }
    }
    // 所在区域判断
    if (this.data.address == "") {
      wx.showModal({
        content: "请选择你所在的区域",
        success(res) {}
      })
      return;
    } else {
      this.setData({
        address: this.data.address
      })
    }
    // 详细地址判断
    if (this.data.site_det == "") {
      this.setData({
        show1: "display:block"
      })
    } else {
      this.setData({
        site_det: this.data.site_det
      })
    }
  },
  // /^[u4E00-u9FA5]+$/
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    this.setData({
      region: ""
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function() {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {

  }
})