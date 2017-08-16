# API

## 用户权限API

判断某CAS用户是否具有某权限

### 请求

```text
GET /api/permission/can?username=username&permission=permission
```

### 回应

有权限返回

```json
{
    "can": true,
    "msg": "OK"
}
```

权限不存在、用户不存在、用户无此权限返回

```json
{
    "can": false,
    "msg": "错误信息内容"
}
```

## 用户令牌API

获取某token对应的用户名

### 请求

```text
GET /api/token?token=token
```

### 回应

正常返回

```json
{
    "username": "username",
    "msg": "OK"
}
```

令牌不存在、令牌已过期、令牌对应用户不存在返回

```json
{
    "username": null,
    "msg": "错误信息内容"
}
```
