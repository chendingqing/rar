//app.js
App({
  onLaunch: function () {
    // 展示本地存储能力
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)
  },
  globalData: {
    userInfo: null
  }
})

var httpArr = 'http://chegenqian.com/api/Api/index'; 
var cgqHttp = {
  /**
    *封装全局request请求数据
    *lfs
    *2018-11-1
    *data  发送的数据
    *cmd  请求的方法名
    *cancelTokenSource 回调状态
  */
  postSend(method, data) {
    return new Promise((resolve, reject) => {
      wx.request({
        method: 'POST', //请求方式
        header: {
          'content-type': 'application/json;charset=UTF-8',
          'token': wx.getStorageSync('token')
        }, //请求头部方式
        url: `${httpArr}`, //请求地址
        data: JSON.stringify(data), //请求数据
        success: (res => {
          if (res.data.code == 1) {
            resolve(res);//返回成功
          }
          else if (res.data.code == 0) {
            reject(res); //登录失效
          }
          else if (res.data.code == -1) {
            reject(res);//失败
          }
        }),
        fail: (res => {
          reject(res);//失败
        })
      })
    })
  },

}
module.exports = cgqHttp