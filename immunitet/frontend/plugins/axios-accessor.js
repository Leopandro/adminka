import {
    initializeAxios,
} from '@/shared/utils/api';

const accessor = ({ $axios }) => {
    initializeAxios($axios);
};

export default accessor;
