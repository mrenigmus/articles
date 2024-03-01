import "axios";

declare module "axios" {
    export interface AxiosRequestConfig {
        toastErrors?: boolean;
    }
}
