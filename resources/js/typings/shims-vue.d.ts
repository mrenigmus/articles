import { getTimeDifference } from "@/utils/getTimeDifference";
import moment from "moment";

declare module "@vue/runtime-core" {
    interface ComponentCustomProperties {
        $moment: typeof moment;
        $getTimeDifference: typeof getTimeDifference
    }
}
