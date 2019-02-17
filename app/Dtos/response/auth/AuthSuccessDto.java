package com.melardev.spring.twitterapi.dtos.response.auth;

import com.melardev.spring.twitterapi.dtos.response.SuccessResponse;
import com.melardev.spring.twitterapi.dtos.response.users.UserDetailsDto;
import com.melardev.spring.twitterapi.models.User;

public class AuthSuccessDto extends SuccessResponse {
    private final UserDetailsDto user;
    private String tokenScheme = "Bearer";
    private String token;

    public AuthSuccessDto(String jwt, UserDetailsDto user) {
        super(); // Not needed
        this.token = jwt;
        this.user = user;
    }


    public static AuthSuccessDto build(String jwt, User user) {
        return new AuthSuccessDto(jwt, UserDetailsDto.build(user));
    }

    public UserDetailsDto getUser() {
        return user;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    public String getTokenScheme() {
        return tokenScheme;
    }

    public void setTokenScheme(String tokenScheme) {
        this.tokenScheme = tokenScheme;
    }


}