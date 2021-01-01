后台模版 v 2.0

* 注意：使用后台模版，记得把下面【已有功能】的说明删除，以防出事

* 使用需知
    * 后台默认入口名：/01snt.php，根据项目修改
    * 后台默认账号密码（最好每个项目都修改）：
        * 账号：admin
        * 密码：123456
    * 数据库模版文件，根目录的 template.sql 文件（初始化项目后记得删除）

* 已有功能
    * 已配置跨域
    
    * 根据逗号分割，丢进数组内
        * 方法 api/controller/Base/getArrayByExplode
        
    * 删除最后一个字符
        * 方法 api/controller/Base/delEndString
        
    * 校验参数是否是正整数
        * 方法 api/controller/Base/checkIsIntNumberByArray

    * 截取富文本字符
        * 方法 api/controller/Base/stringToText        
       
    * 生成订单号
        * 方法 api/controller/Base/makeOrderNo
        
    * get 请求数据
        * 方法 api/controller/Base/getCurl
        
    * post 请求数据
        * 方法 api/controller/Base/postCurl
        
    * 生成二维码
        * 方法 api/controller/Base/getQRCOde

    * 微信小程序登录
        * 接口 http://localhost/api/login
        * 方法 api/controller/Login/login
        * ==============================
        * ⚠️：根据提示，补充业务逻辑
        * ==============================
        
    * 微信支付 统一下单
        * 接口 http://localhost/api/pay
        * 方法 api/controller/Pay/pay
        * ==============================
        * ⚠️：根据提示，补充业务逻辑
        * ==============================
        
    * 微信支付 支付回调
        * 接口 无需调用，微信官方调用
        * 方法 api/controller/Pay/response
        * ==============================
        * ⚠️：根据提示，补充支付成功和支付失败的业务逻辑
        * ==============================
        
    * 生成带参数的微信小程序码
        * 接口 无，此方法配合业务使用
        * 方法 api/library/WeChat/MiniProgram/getMPCode
        * ==============================
        * ⚠️：根据注释信息，使用该方法
        * ==============================
        
    * 微信公众号h5授权登录
        * 接口 http://localhost/api/login_gzh
        * 方法 api/controller/Login/wxOfficialAccountLogin
        * ==============================
        * ⚠：根据业务不同，修改新增用户业务代码
        * ==============================
        
    * 发送小程序订阅消息
        * 接口 无，此方法配合业务使用
        * 方法 api/library/WeChat/MiniProgram/sendSubscribeMessage
        * ==============================
        * ⚠️：根据注释信息，使用该方法
        * ==============================
        
    * 获取AccessToken
        * 接口 无，此方法配合业务使用
        * 方法 api/library/WeChat/MiniProgram/getAccessToken
        * ==============================
        * ⚠️：根据注释信息，使用该方法
        * ==============================
        
    * 发送统一的信息 小程序发送公众号消息
        * 接口 无，此方法配合业务使用
        * 方法 api/library/WeChat/MiniProgram/sendUniformMessage
        * ==============================
        * ⚠️：根据注释信息，使用该方法
        * ==============================
        
    * 根据商户订单号退款
        * 接口 无，此方法配合业务使用
        * 方法 api/library/WeChat/Payment/refundByOutTradeNumber
        * ==============================
        * ⚠️：根据注释信息，使用该方法
        * ==============================
        